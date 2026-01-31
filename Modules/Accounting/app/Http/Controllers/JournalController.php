<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date');
        $search = $request->get('search');

        $query = DB::table('journal_heads')
            ->where('isdeleted', 0)
            ->orderBy('jdate', 'desc');

        if ($date) {
            $query->whereDate('jdate', $date);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('info', 'like', "%{$search}%")
                  ->orWhere('journal_id', 'like', "%{$search}%");
            });
        }

        $journals = $query->get();

        // Get journal details for each
        foreach ($journals as $journal) {
            $journal->details = DB::table('journal_entries')
                ->join('acc_head', 'journal_entries.account_id', '=', 'acc_head.id')
                ->where('journal_entries.journal_id', $journal->id)
                ->select('journal_entries.*', 'acc_head.aname', 'acc_head.code')
                ->get();
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::journals.index', compact('journals', 'date', 'search', 'settings', 'lang', ));
    }

    public function create(Request $request)
    {
        $type = $request->get('a'); // 1 = buy asset, 2 = sell asset

        // Get next journal ID
        $maxId = DB::table('journal_heads')->max('journal_id');
        $nextId = $maxId ? ($maxId + 1) : 1;

        // Get accounts
        $accounts = DB::table('acc_head')
            ->where('isdeleted', '<', 1)
            ->orderBy('aname')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::journals.create', compact('nextId', 'accounts', 'type', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journal_id' => 'required|numeric',
            'jdate' => 'required|date',
            'acc_id' => 'required|array',
            'acc_id.*' => 'required|exists:acc_head,id',
            'debit' => 'required|array',
            'credit' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check debit = credit
        $totalDebit = array_sum($request->debit);
        $totalCredit = array_sum($request->credit);

        if (abs($totalDebit - $totalCredit) > 0.01) {
            return redirect()->back()
                ->with('error', 'المدين يجب أن يساوي الدائن')
                ->withInput();
        }

        $userId = session('userid');

        // Insert journal head
        $journalHeadId = DB::table('journal_heads')->insertGetId([
            'journal_id' => $request->journal_id,
            'jdate' => $request->jdate,
            'total' => $request->jdate, // Legacy field
            'details' => $request->info ?? null,
            'user' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert journal entries
        foreach ($request->acc_id as $index => $accId) {
            if ($request->debit[$index] > 0 || $request->credit[$index] > 0) {
                DB::table('journal_entries')->insert([
                    'journal_id' => $journalHeadId,
                    'account_id' => $accId,
                    'debit' => $request->debit[$index] ?? 0,
                    'credit' => $request->credit[$index] ?? 0,
                    'tybe' => $request->debit[$index] > 0 ? 0 : 1,
                    'info' => $request->info_details[$index] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Log process
        DB::table('process')->insert([
            'type' => 'add journal',
            'created_at' => now(),
        ]);

        return redirect()->route('journals.index')
            ->with('success', 'تم إضافة القيد بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('journals.index')
                ->with('error', 'معرف القيد مطلوب');
        }

        $journal = DB::table('journal_heads')->where('id', $id)->first();
        if (!$journal) {
            return redirect()->route('journals.index')
                ->with('error', 'القيد غير موجود');
        }

        $journal->details = DB::table('journal_entries')
            ->where('journal_id', $id)
            ->get();

        $accounts = DB::table('acc_head')
            ->where('isdeleted', '<', 1)
            ->orderBy('aname')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::journals.edit', compact('journal', 'accounts', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('journals.index')
                ->with('error', 'معرف القيد مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'jdate' => 'required|date',
            'acc_id' => 'required|array',
            'acc_id.*' => 'required|exists:acc_head,id',
            'debit' => 'required|array',
            'credit' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check debit = credit
        $totalDebit = array_sum($request->debit);
        $totalCredit = array_sum($request->credit);

        if (abs($totalDebit - $totalCredit) > 0.01) {
            return redirect()->back()
                ->with('error', 'المدين يجب أن يساوي الدائن')
                ->withInput();
        }

        // Update journal head
        DB::table('journal_heads')
            ->where('id', $id)
            ->update([
                'jdate' => $request->jdate,
                'details' => $request->info ?? null,
                'updated_at' => now(),
            ]);

        // Delete old entries
        DB::table('journal_entries')->where('journal_id', $id)->delete();

        // Insert new entries
        foreach ($request->acc_id as $index => $accId) {
            if ($request->debit[$index] > 0 || $request->credit[$index] > 0) {
                DB::table('journal_entries')->insert([
                    'journal_id' => $id,
                    'account_id' => $accId,
                    'debit' => $request->debit[$index] ?? 0,
                    'credit' => $request->credit[$index] ?? 0,
                    'tybe' => $request->debit[$index] > 0 ? 0 : 1,
                    'info' => $request->info_details[$index] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('journals.index')
            ->with('success', 'تم تحديث القيد بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('journals.index')
                ->with('error', 'معرف القيد مطلوب');
        }

        // Soft delete
        DB::table('journal_heads')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('journals.index')
            ->with('success', 'تم حذف القيد بنجاح');
    }

    public function createMulti(Request $request)
    {
        // Get next journal ID
        $maxId = DB::table('journal_heads')->max('journal_id');
        $nextId = $maxId ? ($maxId + 1) : 1;

        // Get accounts
        $accounts = DB::table('acc_head')
            ->where('is_basic', 0)
            ->where('isdeleted', '<', 1)
            ->orderBy('aname')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::journals.create-multi', compact('nextId', 'accounts', 'settings', 'lang', ));
    }

    public function storeMulti(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journal_id' => 'required|numeric',
            'jdate' => 'required|date',
            'details' => 'nullable|string',
            'depitval' => 'required|array',
            'depitval.*' => 'required|numeric|min:0',
            'depitname' => 'required|array',
            'depitname.*' => 'required|exists:acc_head,id',
            'creditval' => 'required|array',
            'creditval.*' => 'required|numeric|min:0',
            'creditname' => 'required|array',
            'creditname.*' => 'required|exists:acc_head,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Calculate totals
        $totalDebit = array_sum($request->depitval);
        $totalCredit = array_sum($request->creditval);

        // Check debit = credit
        if (abs($totalDebit - $totalCredit) > 0.01) {
            return redirect()->back()
                ->with('error', 'المدين يجب أن يساوي الدائن. المدين: ' . number_format($totalDebit, 2) . ' | الدائن: ' . number_format($totalCredit, 2))
                ->withInput();
        }

        $userId = session('userid');

        // Insert journal head
        $journalHeadId = DB::table('journal_heads')->insertGetId([
            'journal_id' => $request->journal_id,
            'jdate' => $request->jdate,
            'total' => $totalDebit, // Store total debit as total
            'details' => $request->details ?? null,
            'user' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert debit entries
        foreach ($request->depitval as $key => $debitValue) {
            if ($debitValue > 0 && isset($request->depitname[$key])) {
                DB::table('journal_entries')->insert([
                    'journal_id' => $journalHeadId,
                    'account_id' => $request->depitname[$key],
                    'debit' => $debitValue,
                    'credit' => 0,
                    'tybe' => 0, // 0 = debit
                    'info' => 'إدخال دين',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Insert credit entries
        foreach ($request->creditval as $key => $creditValue) {
            if ($creditValue > 0 && isset($request->creditname[$key])) {
                DB::table('journal_entries')->insert([
                    'journal_id' => $journalHeadId,
                    'account_id' => $request->creditname[$key],
                    'debit' => 0,
                    'credit' => $creditValue,
                    'tybe' => 1, // 1 = credit
                    'info' => 'إدخال ائتمان',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Log process
        DB::table('process')->insert([
            'type' => 'إضافة قيد',
            'created_at' => now(),
        ]);

        return redirect()->route('journals.index')
            ->with('success', 'تم إضافة القيد المتعدد بنجاح');
    }
}