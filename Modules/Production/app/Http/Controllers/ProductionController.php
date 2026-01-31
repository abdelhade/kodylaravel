<?php

namespace Modules\Production\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductionController extends Controller
{
    public function index()
    {
        $productions = DB::table('productions')
            ->orderBy('snd_id', 'desc')
            ->get();

        // Group by snd_id
        $groupedProductions = $productions->groupBy('snd_id');

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('production::index', compact('groupedProductions', 'settings', 'lang', ));
    }

    public function create()
    {
        $employees = DB::table('employees')
            ->where('isdeleted', 0)
            ->orderBy('name')
            ->get();

        // Get next snd_id
        $maxId = DB::table('productions')->max('snd_id');
        $nextId = ($maxId ?? 0) + 1;

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('production::create', compact('employees', 'nextId', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'snd_id' => 'required|integer',
            'info' => 'nullable|string',
            'emp_name' => 'required|array',
            'emp_name.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:0',
            'price' => 'required|array',
            'price.*' => 'required|numeric|min:0',
            'val' => 'required|array',
            'val.*' => 'required|numeric|min:0',
            'info2' => 'nullable|array',
            'info2.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sndId = $request->snd_id;
        $date = $request->date;
        $info = $request->info ?? '';

        foreach ($request->emp_name as $index => $empName) {
            DB::table('productions')->insert([
                'snd_id' => $sndId,
                'date' => $date,
                'emp_name' => $empName,
                'qty' => $request->qty[$index] ?? 0,
                'price' => $request->price[$index] ?? 0,
                'value' => $request->val[$index] ?? 0,
                'info' => $info,
                'info2' => $request->info2[$index] ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('process')->insert([
            'type' => 'add production',
            'created_at' => now(),
        ]);

        return redirect()->route('production.index')
            ->with('success', 'تم إضافة الإنتاجية بنجاح');
    }

    public function edit(Request $request)
    {
        $sndId = $request->get('edit');
        if (!$sndId) {
            return redirect()->back()->with('error', 'معرف الإنتاجية مطلوب');
        }

        $productions = DB::table('productions')
            ->where('snd_id', $sndId)
            ->get();

        if ($productions->isEmpty()) {
            return redirect()->back()->with('error', 'الإنتاجية غير موجودة');
        }

        $employees = DB::table('employees')
            ->where('isdeleted', 0)
            ->orderBy('name')
            ->get();

        $firstProduction = $productions->first();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('production::edit', compact('productions', 'employees', 'firstProduction', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $sndId = $request->get('edit');
        if (!$sndId) {
            return redirect()->back()->with('error', 'معرف الإنتاجية مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'snd_id' => 'required|integer',
            'info' => 'nullable|string',
            'emp_name' => 'required|array',
            'emp_name.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:0',
            'price' => 'required|array',
            'price.*' => 'required|numeric|min:0',
            'val' => 'required|array',
            'val.*' => 'required|numeric|min:0',
            'info2' => 'nullable|array',
            'info2.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Delete old records
        DB::table('productions')->where('snd_id', $sndId)->delete();

        // Insert new records
        $newSndId = $request->snd_id;
        $date = $request->date;
        $info = $request->info ?? '';

        foreach ($request->emp_name as $index => $empName) {
            DB::table('productions')->insert([
                'snd_id' => $newSndId,
                'date' => $date,
                'emp_name' => $empName,
                'qty' => $request->qty[$index] ?? 0,
                'price' => $request->price[$index] ?? 0,
                'value' => $request->val[$index] ?? 0,
                'info' => $info,
                'info2' => $request->info2[$index] ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('production.index')
            ->with('success', 'تم تحديث الإنتاجية بنجاح');
    }

    public function destroy(Request $request)
    {
        $sndId = $request->get('snd_id');
        if (!$sndId) {
            return redirect()->back()->with('error', 'معرف الإنتاجية مطلوب');
        }

        DB::table('productions')->where('snd_id', $sndId)->delete();

        return redirect()->route('production.index')
            ->with('success', 'تم حذف الإنتاجية بنجاح');
    }
}