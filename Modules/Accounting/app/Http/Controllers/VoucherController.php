<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('t'); // recive or payment
        $proType = null;
        
        if ($type == 'recive') {
            $proType = 1;
        } elseif ($type == 'payment') {
            $proType = 2;
        }

        // Build query
        $query = DB::table('ot_head as h')
            ->join('acc_head as acc1', 'h.acc1', '=', 'acc1.id')
            ->join('acc_head as acc2', 'h.acc2', '=', 'acc2.id')
            ->select('h.id', 'h.pro_date', 'h.pro_tybe', 'h.pro_value', 'h.pro_id', 
                     'acc1.aname as acc1_name', 'acc2.aname as acc2_name');

        if ($proType) {
            $query->where('h.pro_tybe', $proType);
        }

        // Handle search/filter
        if ($request->isMethod('post')) {
            if ($request->tybe) {
                $query->where('h.pro_tybe', $request->tybe);
            }
            if ($request->strt) {
                $query->where('h.pro_date', '>=', $request->strt);
            }
            if ($request->end) {
                $query->where('h.pro_date', '<=', $request->end);
            }
        }

        $vouchers = $query->where('h.id', '>', 1)->orderBy('h.id', 'desc')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::vouchers.index', compact('vouchers', 'type', 'settings', 'lang', ));
    }

    public function create(Request $request)
    {
        $type = $request->get('t'); // recive or payment
        if (!$type || !in_array($type, ['recive', 'payment'])) {
            return redirect()->route('vouchers.index')
                ->with('error', 'يبدو انك دخلت بطريقة مخالفة للمعايير');
        }

        $proType = $type == 'recive' ? 1 : 2;

        // Get next voucher ID
        $lastVoucher = DB::table('ot_head')
            ->where('pro_tybe', $proType)
            ->orderBy('id', 'desc')
            ->first();
        
        $nextId = $lastVoucher ? ($lastVoucher->pro_id + 1) : 1;

        // Get accounts
        $accounts = DB::table('acc_head')
            ->where('isdeleted', '<', 1)
            ->orderBy('aname')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::vouchers.create', compact('type', 'proType', 'nextId', 'accounts', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tybe' => 'required|in:1,2',
            'voucher_id' => 'required|numeric',
            'vdate' => 'required|date',
            'acc1' => 'required|exists:acc_head,id',
            'acc2' => 'required|exists:acc_head,id',
            'pro_value' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('ot_head')->insert([
            'pro_id' => $request->voucher_id,
            'pro_date' => $request->vdate,
            'pro_tybe' => $request->tybe,
            'pro_value' => $request->pro_value,
            'acc1' => $request->acc1,
            'acc2' => $request->acc2,
            'info' => $request->info ?? null,
            'ins_id' => $request->ins_id ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $type = $request->tybe == 1 ? 'recive' : 'payment';
        return redirect()->route('vouchers.index', ['t' => $type])
            ->with('success', 'تم إضافة السند بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('edit');
        if (!$id) {
            return redirect()->route('vouchers.index')
                ->with('error', 'معرف السند مطلوب');
        }

        $voucher = DB::table('ot_head')->where('id', $id)->first();
        if (!$voucher) {
            return redirect()->route('vouchers.index')
                ->with('error', 'السند غير موجود');
        }

        $type = $voucher->pro_tybe == 1 ? 'recive' : 'payment';
        $accounts = DB::table('acc_head')
            ->where('isdeleted', '<', 1)
            ->orderBy('aname')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::vouchers.edit', compact('voucher', 'type', 'accounts', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('vouchers.index')
                ->with('error', 'معرف السند مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'vdate' => 'required|date',
            'acc1' => 'required|exists:acc_head,id',
            'acc2' => 'required|exists:acc_head,id',
            'pro_value' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('ot_head')
            ->where('id', $id)
            ->update([
                'pro_date' => $request->vdate,
                'pro_value' => $request->pro_value,
                'acc1' => $request->acc1,
                'acc2' => $request->acc2,
                'info' => $request->info ?? null,
                'updated_at' => now(),
            ]);

        $voucher = DB::table('ot_head')->where('id', $id)->first();
        $type = $voucher->pro_tybe == 1 ? 'recive' : 'payment';

        return redirect()->route('vouchers.index', ['t' => $type])
            ->with('success', 'تم تحديث السند بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('vouchers.index')
                ->with('error', 'معرف السند مطلوب');
        }

        DB::table('ot_head')->where('id', $id)->delete();

        return redirect()->route('vouchers.index')
            ->with('success', 'تم حذف السند بنجاح');
    }
}