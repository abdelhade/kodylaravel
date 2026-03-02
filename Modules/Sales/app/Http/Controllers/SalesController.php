<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Sales\Models\Invoice;
use Modules\Sales\Models\InvoiceDetail;

class SalesController extends Controller
{
    // تعريف ثوابت أنواع الفواتير
    const INVOICE_TYPES = [
        'PURCHASE' => 4,           // مشتريات
        'SALES' => 3,              // مبيعات  
        'POS' => 9,                // كاشير
        'PURCHASE_RETURN' => 10,   // مردود مشتريات
        'SALES_RETURN' => 11       // مردود مبيعات
    ];

    // تعريف أنواع العمليات المحاسبية
    const ACCOUNTING_TYPES = [
        'RECEIPT' => 1,            // سند قبض
        'PAYMENT' => 2,            // سند دفع
        'SALES_DISC' => 7,         // خصم مبيعات
        'PURCHASE_DISC' => 6       // خصم مشتريات
    ];

    /**
     * عرض قائمة الفواتير
     */
    public function index()
    {
        $invoices = Invoice::notDeleted()
            ->whereIn('pro_tybe', [
                self::INVOICE_TYPES['SALES'],      // 3
                self::INVOICE_TYPES['POS'],        // 9 - إضافة فواتير POS
                self::INVOICE_TYPES['SALES_RETURN'] // 11
            ])
            ->orderBy('id', 'desc')
            ->paginate(20);

        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        return view('sales::invoices.index', compact('invoices', 'settings', 'lang'));
    }

    /**
     * عرض صفحة فاتورة المبيعات
     */
    public function saleInvoice()
    {
        $pro_tybe = self::INVOICE_TYPES['SALES'];
        $invoice_title = 'فاتورة مبيعات';
        $is_edit_mode = false;
        
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('sales::invoices.sales', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'settings', 'lang'));
    }

    /**
     * عرض صفحة مردود المبيعات
     */
    public function saleReturn()
    {
        $pro_tybe = self::INVOICE_TYPES['SALES_RETURN'];
        $invoice_title = 'فاتورة مردود مبيعات';
        $is_edit_mode = false;
        
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('sales::invoices.sales', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'settings', 'lang'));
    }

    /**
     * عرض صفحة أمر البيع
     */
    public function saleOrder()
    {
        $pro_tybe = 8; // نوع أمر البيع
        $invoice_title = 'أمر بيع';
        $is_edit_mode = false;
        
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('sales::invoices.sales', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'settings', 'lang'));
    }
    
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

    public function edit($id)
    {
        $invoice = DB::table('ot_head')->where('id', $id)->where('isdeleted', 0)->first();
        
        if (!$invoice) {
            return redirect()->route('sales.invoice')->with('error', 'الفاتورة غير موجودة');
        }

        $pro_tybe = (int) $invoice->pro_tybe;
        $invoice_title = 'تعديل فاتورة المبيعات';
        $is_edit_mode = true;
        $invoice_data = $invoice;
        
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('sales::invoices.sales', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'invoice_data', 'settings', 'lang'));
    }

    private function updateStock($item_id, $store_id, $qty, $operation = 'add')
    {
        // Stock management disabled - table doesn't exist
        return true;
    }
    
    /**
     * إضافة فاتورة مبيعات جديدة
     */
    public function store(Request $request)
    {
        try {
            Log::info('Sales Invoice Store Request', [
                'pro_tybe' => $request->input('pro_tybe'),
                'items_count' => count($request->input('itmname', []))
            ]);

            DB::beginTransaction();

            $pro_tybe = $request->input('pro_tybe');
            $pro_date = $request->input('pro_date', date('Y-m-d'));
            $store_id = $request->input('store_id');
            $acc2_id = $request->input('acc2_id');
            $emp_id = $request->input('emp_id');
            $headtotal = $request->input('headtotal', 0);
            $headdisc = $request->input('headdisc', 0);
            $headnet = $request->input('headnet', 0);
            $info = $request->input('info', '');

            // Validation
            if (empty($pro_tybe)) {
                throw new \Exception('نوع الفاتورة مطلوب');
            }

            // إنشاء رأس الفاتورة
            $last_op = DB::table('ot_head')->insertGetId([
                'pro_tybe' => $pro_tybe,
                'pro_date' => $pro_date,
                'store_id' => $store_id,
                'emp_id' => $emp_id,
                'acc1' => $store_id,
                'acc2' => $acc2_id,
                'fat_total' => $headtotal,
                'fat_disc' => $headdisc,
                'fat_net' => $headnet,
                'info' => $info,
                'user' => Auth::id() ?? 1,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0
            ]);

            Log::info('Invoice created', ['id' => $last_op]);

            // معالجة تفاصيل الفاتورة
            $items = $request->input('itmname', []);
            $itemsInserted = 0;
            
            foreach ($items as $index => $item_id) {
                if (empty($item_id)) continue;

                $qty = $request->input('itmqty')[$index] ?? 0;
                $price = $request->input('itmprice')[$index] ?? 0;
                $disc = $request->input('itmdisc')[$index] ?? 0;

                if ($qty <= 0 || $price < 0) continue;

                // إدراج تفاصيل الفاتورة
                DB::table('fat_details')->insert([
                    'fat_id' => $last_op,
                    'item_id' => $item_id,
                    'quantity' => $qty,
                    'price' => $price,
                    'total' => $qty * ($price - $disc),
                    'crtime' => now()
                ]);
                
                $itemsInserted++;
            }
            
            Log::info('Invoice details inserted', ['count' => $itemsInserted]);

            if ($itemsInserted == 0) {
                throw new \Exception('يجب إضافة صنف واحد على الأقل');
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'تم حفظ الفاتورة بنجاح - رقم: ' . $last_op);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sales Invoice Store Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * تحديث فاتورة
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Sales Invoice Update Request', [
                'id' => $id,
                'pro_tybe' => $request->input('pro_tybe'),
                'items_count' => count($request->input('itmname', []))
            ]);

            DB::beginTransaction();

            $pro_tybe = $request->input('pro_tybe');
            $pro_date = $request->input('pro_date', date('Y-m-d'));
            $store_id = $request->input('store_id');
            $acc2_id = $request->input('acc2_id');
            $emp_id = $request->input('emp_id');
            $headtotal = $request->input('headtotal', 0);
            $headdisc = $request->input('headdisc', 0);
            $headnet = $request->input('headnet', 0);
            $info = $request->input('info', '');

            // Validation
            if (empty($pro_tybe)) {
                throw new \Exception('نوع الفاتورة مطلوب');
            }

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
                'fat_net' => $headnet,
                'mdtime' => now()
            ]);

            Log::info('Invoice header updated', ['id' => $id]);

            // حذف التفاصيل القديمة
            DB::table('fat_details')->where('fat_id', $id)->delete();

            // إضافة التفاصيل الجديدة
            $items = $request->input('itmname', []);
            $itemsInserted = 0;
            
            foreach ($items as $index => $item_id) {
                if (empty($item_id)) continue;

                $qty = $request->input('itmqty')[$index] ?? 0;
                $price = $request->input('itmprice')[$index] ?? 0;
                $disc = $request->input('itmdisc')[$index] ?? 0;

                if ($qty <= 0 || $price < 0) continue;

                // إدراج تفاصيل الفاتورة
                DB::table('fat_details')->insert([
                    'fat_id' => $id,
                    'item_id' => $item_id,
                    'quantity' => $qty,
                    'price' => $price,
                    'total' => $qty * ($price - $disc),
                    'crtime' => now()
                ]);
                
                $itemsInserted++;
            }
            
            Log::info('Invoice details updated', ['count' => $itemsInserted]);

            if ($itemsInserted == 0) {
                throw new \Exception('يجب إضافة صنف واحد على الأقل');
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'تم تحديث الفاتورة بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sales Invoice Update Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف فاتورة
     */
    public function destroy($id)
    {
        try {
            DB::table('ot_head')->where('id', $id)->update(['isdeleted' => 1]);
            DB::table('fat_details')->where('fat_id', $id)->delete();

            return redirect()->route('sales.index')->with('success', 'تم حذف الفاتورة بنجاح');
        } catch (\Exception $e) {
            Log::error('خطأ في حذف الفاتورة: ' . $e->getMessage());
            return back()->withErrors(['error' => 'حدث خطأ أثناء حذف الفاتورة']);
        }
    }
    
    /**
     * الحصول على مخزون المخزن
     */
    public function getStoreInventory($storeId)
    {
        // Return empty array - stock_details table doesn't exist
        return response()->json(['items' => []]);
    }
}
