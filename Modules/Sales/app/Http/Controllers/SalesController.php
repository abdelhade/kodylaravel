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
        $invoice = DB::table('ot_head')->where('id', $id)->first();
        
        if (!$invoice) {
            return redirect()->route('sales.invoice')->with('error', 'الفاتورة غير موجودة');
        }

        $pro_tybe = $invoice->pro_tybe;
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
                
                // تحديث كمية الصنف في جدول myitems (نقص للمبيعات)
                if ($pro_tybe == 3) { // فاتورة مبيعات
                    DB::table('myitems')
                        ->where('id', $item_id)
                        ->decrement('itmqty', $qty);
                }
                
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
                'mdtime' => now()
            ]);

            // جمع الأصناف المتأثرة قبل الحذف
            $affectedItems = DB::table('fat_details')
                ->where('pro_id', $id)
                ->where('isdeleted', 0)
                ->pluck('item_id')
                ->unique()
                ->toArray();

            // حذف التفاصيل القديمة (soft delete)
            DB::table('fat_details')->where('pro_id', $id)->update(['isdeleted' => 1]);

            // إضافة التفاصيل الجديدة
            $items = $request->input('itmname', []);
            foreach ($items as $index => $item_id) {
                if (empty($item_id)) continue;

                $qty = $request->input('itmqty')[$index];
                $price = $request->input('itmprice')[$index];
                $disc = $request->input('itmdisc')[$index] ?? 0;
                $u_val = $request->input('u_val')[$index] ?? 1;

                $qty_in = 0;
                $qty_out = 0;
                
                if ($pro_tybe == self::INVOICE_TYPES['SALES']) {
                    // مبيعات = خروج من المخزن
                    $qty_out = $qty * $u_val;
                } elseif ($pro_tybe == self::INVOICE_TYPES['SALES_RETURN']) {
                    // مردود مبيعات = دخول للمخزن
                    $qty_in = $qty * $u_val;
                }

                DB::table('fat_details')->insert([
                    'pro_tybe' => $pro_tybe,
                    'pro_id' => $id,
                    'item_id' => $item_id,
                    'u_val' => $u_val,
                    'qty_in' => $qty_in,
                    'qty_out' => $qty_out,
                    'price' => $price / $u_val,
                    'discount' => $disc,
                    'det_value' => $qty * ($price - $disc),
                    'fatid' => $id,
                    'fat_tybe' => $pro_tybe,
                    'det_store' => $store_id,
                    'crtime' => now(),
                    'isdeleted' => 0
                ]);
                
                // إضافة الصنف للقائمة المتأثرة
                if (!in_array($item_id, $affectedItems)) {
                    $affectedItems[] = $item_id;
                }
            }

            // تحديث كميات جميع الأصناف المتأثرة
            foreach ($affectedItems as $item_id) {
                DB::statement("
                    UPDATE myitems 
                    SET itmqty = (
                        SELECT COALESCE(SUM(qty_in), 0) - COALESCE(SUM(qty_out), 0)
                        FROM fat_details
                        WHERE item_id = ? AND isdeleted = 0
                    )
                    WHERE id = ?
                ", [$item_id, $item_id]);
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'تم تحديث الفاتورة بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('خطأ في تحديث الفاتورة: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف فاتورة
     */
    public function destroy($id)
    {
        try {
            DB::table('ot_head')->where('id', $id)->update(['isdeleted' => 1]);
            DB::table('fat_details')->where('pro_id', $id)->update(['isdeleted' => 1]);

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
