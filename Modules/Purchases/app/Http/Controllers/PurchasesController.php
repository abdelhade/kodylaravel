<?php

namespace Modules\Purchases\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchasesController extends Controller
{
    // أنواع الفواتير
    const INVOICE_TYPES = [
        'PURCHASE' => 4,
        'PURCHASE_RETURN' => 10,
        'PURCHASE_ORDER' => 12
    ];

    /**
     * عرض صفحة فاتورة المشتريات
     */
    public function purchaseInvoice()
    {
        $pro_tybe = self::INVOICE_TYPES['PURCHASE'];
        $invoice_title = 'فاتورة مشتريات';
        $is_edit_mode = false;
        
        // Get settings and language
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::invoices.purchase', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'settings', 'lang'));
    }

    /**
     * عرض صفحة فاتورة مردود مشتريات
     */
    public function purchaseReturn()
    {
        $pro_tybe = self::INVOICE_TYPES['PURCHASE_RETURN'];
        $invoice_title = 'فاتورة مردود مشتريات';
        $is_edit_mode = false;
        
        // Get settings and language
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::invoices.purchase', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'settings', 'lang'));
    }

    /**
     * عرض صفحة أمر شراء
     */
    public function purchaseOrder()
    {
        $pro_tybe = self::INVOICE_TYPES['PURCHASE_ORDER'];
        $invoice_title = 'أمر شراء';
        $is_edit_mode = false;
        
        // Get settings and language
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::invoices.purchase', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'settings', 'lang'));
    }
    
    /**
     * Get language array
     */
    private function getLanguageArray()
    {
        return cache()->remember('language_ar', 3600, function () {
            // محاولة الحصول من الـ cache أولاً
            $cached = cache()->get('laravel-cache-language_ar');
            if ($cached) {
                return $cached;
            }
            
            // إذا لم يكن موجوداً، إرجاع array فارغ
            return [];
        });
    }

    /**
     * عرض صفحة تعديل فاتورة
     */
    public function edit($id)
    {
        $invoice = DB::table('ot_head')->where('id', $id)->first();
        
        if (!$invoice) {
            return redirect()->route('purchases.invoice')->with('error', 'الفاتورة غير موجودة');
        }

        $pro_tybe = $invoice->pro_tybe;
        $invoice_title = 'تعديل فاتورة المشتريات';
        $is_edit_mode = true;
        $invoice_data = $invoice;
        
        return view('purchases::invoices.purchase', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'invoice_data'));
    }

    /**
     * حفظ فاتورة جديدة
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $pro_tybe = $request->input('pro_tybe');
            $store_id = $request->input('store_id');
            $acc2_id = $request->input('acc2_id'); // المورد
            $emp_id = $request->input('emp_id');
            $pro_date = $request->input('pro_date', date('Y-m-d'));
            $headtotal = $request->input('headtotal', 0);
            $headdisc = $request->input('headdisc', 0);
            $headplus = $request->input('headplus', 0);
            $headnet = $request->input('headnet', 0);
            $info = $request->input('info', '');

            // الحصول على رقم الفاتورة التالي
            $pro_id = $this->getNextInvoiceNumber($pro_tybe);

            // إدخال رأس الفاتورة
            $last_op = DB::table('ot_head')->insertGetId([
                'pro_id' => $pro_id,
                'pro_tybe' => $pro_tybe,
                'is_stock' => 1,
                'is_journal' => 1,
                'journal_tybe' => $pro_tybe,
                'info' => $info,
                'pro_date' => $pro_date,
                'store_id' => $store_id,
                'emp_id' => $emp_id,
                'acc1' => $store_id,
                'acc2' => $acc2_id,
                'fat_total' => $headtotal,
                'fat_disc' => $headdisc,
                'fat_plus' => $headplus,
                'fat_net' => $headnet,
                'user' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // إدخال تفاصيل الفاتورة
            $items = $request->input('itmname', []);
            foreach ($items as $index => $item_id) {
                if (empty($item_id)) continue;

                $qty = $request->input('itmqty')[$index];
                $price = $request->input('itmprice')[$index];
                $disc = $request->input('itmdisc')[$index] ?? 0;
                $u_val = $request->input('u_val')[$index] ?? 1;

                DB::table('fat_details')->insert([
                    'pro_tybe' => $pro_tybe,
                    'pro_id' => $last_op,
                    'item_id' => $item_id,
                    'u_val' => $u_val,
                    'qty_in' => $qty * $u_val,
                    'price' => $price / $u_val,
                    'discount' => $disc,
                    'det_value' => $qty * ($price - $disc),
                    'fatid' => $last_op,
                    'fat_tybe' => $pro_tybe,
                    'det_store' => $store_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('purchases.invoice')->with('success', 'تم حفظ الفاتورة بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * الحصول على رقم الفاتورة التالي
     */
    private function getNextInvoiceNumber($invoice_type)
    {
        $max_id = DB::table('ot_head')
            ->where('pro_tybe', $invoice_type)
            ->max(DB::raw('CAST(pro_id AS UNSIGNED)'));
        
        return $max_id ? ($max_id + 1) : 1;
    }

    /**
     * تحديث فاتورة موجودة
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $pro_tybe = $request->input('pro_tybe');
            $store_id = $request->input('store_id');
            $acc2_id = $request->input('acc2_id');
            $emp_id = $request->input('emp_id');
            $pro_date = $request->input('pro_date', date('Y-m-d'));
            $headtotal = $request->input('headtotal', 0);
            $headdisc = $request->input('headdisc', 0);
            $headplus = $request->input('headplus', 0);
            $headnet = $request->input('headnet', 0);
            $info = $request->input('info', '');

            // تحديث رأس الفاتورة
            DB::table('ot_head')->where('id', $id)->update([
                'info' => $info,
                'pro_date' => $pro_date,
                'store_id' => $store_id,
                'emp_id' => $emp_id,
                'acc1' => $store_id,
                'acc2' => $acc2_id,
                'fat_total' => $headtotal,
                'fat_disc' => $headdisc,
                'fat_plus' => $headplus,
                'fat_net' => $headnet,
                'updated_at' => now()
            ]);

            // حذف التفاصيل القديمة
            DB::table('fat_details')->where('pro_id', $id)->update(['isdeleted' => 1]);

            // إدخال تفاصيل جديدة
            $items = $request->input('itmname', []);
            foreach ($items as $index => $item_id) {
                if (empty($item_id)) continue;

                $qty = $request->input('itmqty')[$index];
                $price = $request->input('itmprice')[$index];
                $disc = $request->input('itmdisc')[$index] ?? 0;
                $u_val = $request->input('u_val')[$index] ?? 1;

                DB::table('fat_details')->insert([
                    'pro_tybe' => $pro_tybe,
                    'pro_id' => $id,
                    'item_id' => $item_id,
                    'u_val' => $u_val,
                    'qty_in' => $qty * $u_val,
                    'price' => $price / $u_val,
                    'discount' => $disc,
                    'det_value' => $qty * ($price - $disc),
                    'fatid' => $id,
                    'fat_tybe' => $pro_tybe,
                    'det_store' => $store_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'تم تحديث الفاتورة بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * عرض قائمة الفواتير
     */
    public function index()
    {
        $invoices = DB::table('ot_head')
            ->where('pro_tybe', self::INVOICE_TYPES['PURCHASE'])
            ->where('isdeleted', 0)
            ->orderBy('id', 'desc')
            ->paginate(20);

        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();

        return view('purchases::invoices.index', compact('invoices', 'settings', 'lang'));
    }
}
