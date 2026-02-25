<?php

namespace Modules\Voucher\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    /**
     * دالة للحصول على اللغة من الكاش
     */
    private function getLanguageArray()
    {
        return cache()->remember('language_ar', 3600, function () {
            $cached = cache()->get('laravel-cache-language_ar');
            if ($cached) {
                return $cached;
            }
            return [];
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        // بناء الاستعلام الأساسي
        $query = DB::table('ot_head as h')
            ->join('acc_head as acc1', 'h.acc1', '=', 'acc1.id')
            ->join('acc_head as acc2', 'h.acc2', '=', 'acc2.id')
            ->select(
                'h.id',
                'h.pro_date',
                'h.pro_tybe',
                'h.pro_value',
                'h.pro_id',
                'h.info',
                'acc1.aname as acc1_name',
                'acc2.aname as acc2_name'
            )
            ->whereIn('h.pro_tybe', [1, 2]); // 1 = قبض, 2 = دفع
        
        // فلترة حسب النوع
        if ($request->has('t')) {
            if ($request->t == 'recive') {
                $query->where('h.pro_tybe', 1);
            } elseif ($request->t == 'payment') {
                $query->where('h.pro_tybe', 2);
            }
        }
        
        // فلترة حسب التاريخ
        if ($request->filled('tybe')) {
            $query->where('h.pro_tybe', $request->tybe);
        }
        
        if ($request->filled('strt')) {
            $query->where('h.pro_date', '>=', $request->strt);
        }
        
        if ($request->filled('end')) {
            $query->where('h.pro_date', '<=', $request->end);
        }
        
        $vouchers = $query->orderBy('h.id', 'desc')->paginate(50);
        
        return view('voucher::index', compact('vouchers', 'settings', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        // تحديد نوع السند
        $voucher_type = $request->get('t', 'recive'); // recive or payment
        $pro_tybe = ($voucher_type == 'recive') ? 1 : 2;
        
        // الحصول على آخر رقم سند
        $last_voucher = DB::table('ot_head')
            ->where('pro_tybe', $pro_tybe)
            ->orderBy('id', 'desc')
            ->first();
        
        $next_voucher_id = $last_voucher ? $last_voucher->pro_id + 1 : 1;
        
        // الحصول على الحسابات (غير الصناديق)
        $accounts = DB::table('acc_head')
            ->where('is_basic', 0)
            ->where('is_fund', '!=', 1)
            ->get();
        
        // الحصول على حسابات الصناديق
        $fund_accounts = DB::table('acc_head')
            ->where('is_basic', 0)
            ->where('is_fund', 1)
            ->get();
        
        // الحصول على مراكز التكلفة
        $cost_centers = DB::table('cost_centers')->get();
        
        return view('voucher::create', compact(
            'settings',
            'lang',
            'voucher_type',
            'pro_tybe',
            'next_voucher_id',
            'accounts',
            'fund_accounts',
            'cost_centers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $user = auth()->id() ?? 1;
            $tybe = $request->input('tybe');
            $val = $request->input('val');
            $account = $request->input('account');
            $fund_account = $request->input('fund_account');
            $voucher_id = $request->input('voucher_id');
            $vdate = $request->input('vdate', date('Y-m-d'));
            $cost_center = $request->input('cost_center');
            $info = $request->input('info');
            
            // تحديد الحسابات المدينة والدائنة
            if ($tybe == 1) { // سند قبض
                $debit_acc = $fund_account;
                $credit_acc = $account;
            } else { // سند دفع
                $debit_acc = $account;
                $credit_acc = $fund_account;
            }
            
            // إدراج السند
            $ins_voucher = DB::table('ot_head')->insertGetId([
                'pro_id' => $voucher_id,
                'branch_id' => 1,
                'pro_tybe' => $tybe,
                'is_finance' => 1,
                'is_journal' => 1,
                'journal_tybe' => $tybe,
                'info' => $info,
                'pro_date' => $vdate,
                'pro_num' => $voucher_id,
                'acc1' => $debit_acc,
                'acc2' => $credit_acc,
                'pro_value' => $val,
                'cost_center' => $cost_center,
                'user' => $user,
                'crtime' => now()
            ]);
            
            // إنشاء قيد يومية
            $last_journal = DB::table('journal_heads')
                ->orderBy('journal_id', 'desc')
                ->first();
            
            $journal_id = $last_journal ? $last_journal->journal_id + 1 : 1;
            
            $journal_head_id = DB::table('journal_heads')->insertGetId([
                'journal_id' => $journal_id,
                'total' => $val,
                'jdate' => $vdate,
                'details' => "سند مالي _ $info",
                'op2' => $ins_voucher,
                'user' => $user
            ]);
            
            // قيد المدين
            DB::table('journal_entries')->insert([
                'journal_id' => $journal_head_id,
                'account_id' => $debit_acc,
                'debit' => $val,
                'credit' => 0,
                'tybe' => 0,
                'op2' => $ins_voucher
            ]);
            
            // قيد الدائن
            DB::table('journal_entries')->insert([
                'journal_id' => $journal_head_id,
                'account_id' => $credit_acc,
                'debit' => 0,
                'credit' => $val,
                'tybe' => 1,
                'op2' => $ins_voucher
            ]);
            
            DB::commit();
            
            $type = $tybe == 1 ? 'recive' : 'payment';
            return redirect()->route('voucher.index', ['t' => $type])
                ->with('success', 'تم حفظ السند بنجاح');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('voucher::show', compact('settings', 'lang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        $voucher = DB::table('ot_head')->where('id', $id)->first();
        
        if (!$voucher) {
            return redirect()->route('voucher.index')->with('error', 'السند غير موجود');
        }
        
        $voucher_type = $voucher->pro_tybe == 1 ? 'recive' : 'payment';
        $pro_tybe = $voucher->pro_tybe;
        
        // الحصول على الحسابات
        $accounts = DB::table('acc_head')
            ->where('is_basic', 0)
            ->where('is_fund', '!=', 1)
            ->get();
        
        $fund_accounts = DB::table('acc_head')
            ->where('is_basic', 0)
            ->where('is_fund', 1)
            ->get();
        
        $cost_centers = DB::table('cost_centers')->get();
        
        return view('voucher::edit', compact(
            'settings',
            'lang',
            'voucher',
            'voucher_type',
            'pro_tybe',
            'accounts',
            'fund_accounts',
            'cost_centers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $tybe = $request->input('tybe');
            $voucher_id = $request->input('voucher_id');
            $vdate = $request->input('vdate');
            $val = $request->input('val');
            $cost_center = $request->input('cost_center');
            $fund_account = $request->input('fund_account');
            $account = $request->input('account');
            $info = $request->input('info');
            
            // تحديد الحسابات
            if ($tybe == 2) { // دفع
                $acc1 = $account;
                $acc2 = $fund_account;
            } else { // قبض
                $acc2 = $account;
                $acc1 = $fund_account;
            }
            
            // تحديث السند
            DB::table('ot_head')->where('id', $id)->update([
                'info' => $info,
                'pro_id' => $voucher_id,
                'pro_date' => $vdate,
                'acc1' => $acc1,
                'acc2' => $acc2,
                'pro_value' => $val,
                'cost_center' => $cost_center,
                'acc_fund' => $fund_account,
                'mdtime' => now()
            ]);
            
            DB::commit();
            
            $type = $tybe == 1 ? 'recive' : 'payment';
            return redirect()->route('voucher.index', ['t' => $type])
                ->with('success', 'تم تحديث السند بنجاح');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $voucher = DB::table('ot_head')->where('id', $id)->first();
            
            if (!$voucher) {
                return back()->with('error', 'السند غير موجود');
            }
            
            $pro_tybe = $voucher->pro_tybe;
            
            // التحقق من أن السند قبض أو دفع فقط
            if ($pro_tybe != 1 && $pro_tybe != 2) {
                return back()->with('error', 'هذا السند مرتبط بعمليات أخرى لا يمكن حذفه');
            }
            
            // حذف القيود المحاسبية
            DB::table('journal_entries')->where('op2', $id)->delete();
            DB::table('journal_heads')->where('op2', $id)->delete();
            
            // حذف السند
            DB::table('ot_head')->where('id', $id)->delete();
            
            DB::commit();
            
            $type = $pro_tybe == 1 ? 'recive' : 'payment';
            return redirect()->route('voucher.index', ['t' => $type])
                ->with('success', 'تم حذف السند بنجاح');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
}
