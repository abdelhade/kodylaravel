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
        'SALES_ORDER' => 8,        // أمر بيع
        'POS' => 9,                // كاشير
        'PURCHASE_RETURN' => 10,   // مردود مشتريات
        'SALES_RETURN' => 11,      // مردود مبيعات
        'QUOTATION' => 12          // عرض سعر (مستقل)
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
    public function index(Request $request)
    {
        $query = Invoice::notDeleted()
            ->whereIn('pro_tybe', [
                self::INVOICE_TYPES['SALES'],        // 3 - فاتورة مبيعات
                self::INVOICE_TYPES['SALES_ORDER'],  // 8 - أمر بيع
                self::INVOICE_TYPES['POS'],          // 9 - نقطة بيع
                self::INVOICE_TYPES['SALES_RETURN'], // 11 - مردود مبيعات
                self::INVOICE_TYPES['QUOTATION']     // 12 - عرض سعر
            ]);

        // فلتر التاريخ
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('crtime', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('crtime', '<=', $request->to_date);
        }
        
        // فلتر نوع العملية
        if ($request->has('invoice_type') && $request->invoice_type) {
            $query->where('pro_tybe', $request->invoice_type);
        }

        $invoices = $query->orderBy('id', 'desc')->paginate(20);

        // إضافة أسماء الحسابات والمستخدمين
        foreach ($invoices as $invoice) {
            if ($invoice->acc2) {
                $acc = DB::table('acc_head')->where('id', $invoice->acc2)->first();
                $invoice->acc2_name = $acc->aname ?? null;
            }
            if ($invoice->user) {
                $user = DB::table('users')->where('id', $invoice->user)->first();
                $invoice->user_name = $user->name ?? 'admin';
            }
        }

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
        $pro_tybe = self::INVOICE_TYPES['SALES_ORDER']; // 8 = أمر بيع
        $invoice_title = 'أمر بيع';
        $is_edit_mode = false;
        
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('sales::invoices.sales', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'settings', 'lang'));
    }

    /**
     * عرض صفحة عرض السعر
     */
    public function quotation()
    {
        $pro_tybe = self::INVOICE_TYPES['QUOTATION']; // 12 = عرض سعر
        $invoice_title = 'عرض سعر';
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
                $u_val = $request->input('u_val')[$index] ?? 1;

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
                
                // تحديث المخزون حسب نوع الفاتورة
                // فقط فواتير المبيعات الفعلية (SALES و POS) تؤثر على المخزون
                // أوامر البيع (SALES_ORDER) وعروض الأسعار (QUOTATION) لا تؤثر على المخزون
                if (in_array($pro_tybe, [self::INVOICE_TYPES['SALES'], self::INVOICE_TYPES['POS']])) {
                    // مبيعات فعلية: تقليل الكمية من المخزون
                    DB::table('myitems')
                        ->where('id', $item_id)
                        ->decrement('itmqty', $qty * $u_val);
                    
                    Log::info('Stock decreased', [
                        'item_id' => $item_id,
                        'qty' => $qty * $u_val,
                        'invoice_type' => $pro_tybe
                    ]);
                } elseif ($pro_tybe == self::INVOICE_TYPES['SALES_RETURN']) {
                    // مردود مبيعات: إضافة الكمية للمخزون
                    DB::table('myitems')
                        ->where('id', $item_id)
                        ->increment('itmqty', $qty * $u_val);
                    
                    Log::info('Stock increased (return)', [
                        'item_id' => $item_id,
                        'qty' => $qty * $u_val,
                        'invoice_type' => $pro_tybe
                    ]);
                } elseif (in_array($pro_tybe, [self::INVOICE_TYPES['SALES_ORDER'], self::INVOICE_TYPES['QUOTATION']])) {
                    // أمر بيع أو عرض سعر: لا يؤثر على المخزون
                    Log::info('Sales order/quotation created (no stock change)', [
                        'item_id' => $item_id,
                        'qty' => $qty,
                        'invoice_type' => $pro_tybe
                    ]);
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

            // إرجاع المخزون من التفاصيل القديمة (فقط للفواتير التي تؤثر على المخزون)
            $oldDetails = DB::table('fat_details')
                ->where('fatid', $id)
                ->get();
            
            foreach ($oldDetails as $detail) {
                // فقط نرجع المخزون إذا كانت الفاتورة من النوع الذي يؤثر على المخزون
                if (in_array($pro_tybe, [self::INVOICE_TYPES['SALES'], self::INVOICE_TYPES['POS']])) {
                    // مبيعات فعلية: نرجع الكمية للمخزون
                    DB::table('myitems')
                        ->where('id', $detail->item_id)
                        ->increment('itmqty', $detail->qty_out ?? 0);
                    
                    Log::info('Stock returned (update)', [
                        'item_id' => $detail->item_id,
                        'qty' => $detail->qty_out ?? 0
                    ]);
                } elseif ($pro_tybe == self::INVOICE_TYPES['SALES_RETURN']) {
                    // مردود مبيعات: نرجع بالتقليل
                    DB::table('myitems')
                        ->where('id', $detail->item_id)
                        ->decrement('itmqty', $detail->qty_in ?? 0);
                    
                    Log::info('Stock decreased (return update)', [
                        'item_id' => $detail->item_id,
                        'qty' => $detail->qty_in ?? 0
                    ]);
                }
                // أوامر البيع (SALES_ORDER): لا نفعل شيء لأنها لم تؤثر على المخزون أصلاً
            }

            // حذف التفاصيل القديمة
            DB::table('fat_details')->where('fatid', $id)->delete();

            // إضافة التفاصيل الجديدة
            $items = $request->input('itmname', []);
            $itemsInserted = 0;
            
            foreach ($items as $index => $item_id) {
                if (empty($item_id)) continue;

                $qty = $request->input('itmqty')[$index] ?? 0;
                $price = $request->input('itmprice')[$index] ?? 0;
                $disc = $request->input('itmdisc')[$index] ?? 0;
                $u_val = $request->input('u_val')[$index] ?? 1;

                if ($qty <= 0 || $price < 0) continue;

                // إدراج تفاصيل الفاتورة
                DB::table('fat_details')->insert([
                    'pro_tybe' => $pro_tybe,
                    'pro_id' => $id,
                    'fatid' => $id,
                    'fat_tybe' => $pro_tybe,
                    'item_id' => $item_id,
                    'u_val' => $u_val,
                    'qty_in' => 0,
                    'qty_out' => 0,
                    'price' => $price,
                    'discount' => $disc,
                    'det_value' => $qty * ($price - $disc),
                    'det_store' => $store_id,
                    'crtime' => now()
                ]);
                
                // تحديث المخزون حسب نوع الفاتورة
                // فقط فواتير المبيعات الفعلية (SALES و POS) تؤثر على المخزون
                if (in_array($pro_tybe, [self::INVOICE_TYPES['SALES'], self::INVOICE_TYPES['POS']])) {
                    // مبيعات فعلية: تقليل الكمية من المخزون
                    DB::table('myitems')
                        ->where('id', $item_id)
                        ->decrement('itmqty', $qty * $u_val);
                    
                    Log::info('Stock decreased (update)', [
                        'item_id' => $item_id,
                        'qty' => $qty * $u_val
                    ]);
                } elseif ($pro_tybe == self::INVOICE_TYPES['SALES_RETURN']) {
                    // مردود مبيعات: إضافة الكمية للمخزون
                    DB::table('myitems')
                        ->where('id', $item_id)
                        ->increment('itmqty', $qty * $u_val);
                    
                    Log::info('Stock increased (return update)', [
                        'item_id' => $item_id,
                        'qty' => $qty * $u_val
                    ]);
                } elseif (in_array($pro_tybe, [self::INVOICE_TYPES['SALES_ORDER'], self::INVOICE_TYPES['QUOTATION']])) {
                    // أمر بيع أو عرض سعر: لا يؤثر على المخزون
                    Log::info('Sales order/quotation updated (no stock change)', [
                        'item_id' => $item_id,
                        'qty' => $qty
                    ]);
                }
                
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
            DB::beginTransaction();
            
            // الحصول على نوع الفاتورة
            $invoice = DB::table('ot_head')->where('id', $id)->first();
            
            if (!$invoice) {
                throw new \Exception('الفاتورة غير موجودة');
            }
            
            // إرجاع المخزون من التفاصيل (فقط للفواتير التي تؤثر على المخزون)
            $details = DB::table('fat_details')
                ->where('fatid', $id)
                ->get();
            
            foreach ($details as $detail) {
                // فقط نرجع المخزون إذا كانت الفاتورة من النوع الذي يؤثر على المخزون
                if (in_array($invoice->pro_tybe, [self::INVOICE_TYPES['SALES'], self::INVOICE_TYPES['POS']])) {
                    // مبيعات فعلية: نرجع الكمية للمخزون
                    DB::table('myitems')
                        ->where('id', $detail->item_id)
                        ->increment('itmqty', $detail->qty_out ?? 0);
                    
                    Log::info('Stock returned (delete)', [
                        'item_id' => $detail->item_id,
                        'qty' => $detail->qty_out ?? 0
                    ]);
                } elseif ($invoice->pro_tybe == self::INVOICE_TYPES['SALES_RETURN']) {
                    // مردود مبيعات: نرجع بالتقليل
                    DB::table('myitems')
                        ->where('id', $detail->item_id)
                        ->decrement('itmqty', $detail->qty_in ?? 0);
                    
                    Log::info('Stock decreased (return delete)', [
                        'item_id' => $detail->item_id,
                        'qty' => $detail->qty_in ?? 0
                    ]);
                } elseif ($invoice->pro_tybe == self::INVOICE_TYPES['SALES_ORDER']) {
                    // أمر بيع: لا نفعل شيء لأنه لم يؤثر على المخزون أصلاً
                    Log::info('Sales order deleted (no stock change)', [
                        'invoice_id' => $id
                    ]);
                }
            }
            
            // حذف الفاتورة والتفاصيل
            DB::table('ot_head')->where('id', $id)->update(['isdeleted' => 1]);
            DB::table('fat_details')->where('fatid', $id)->delete();

            DB::commit();
            
            return redirect()->route('sales.index')->with('success', 'تم حذف الفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('خطأ في حذف الفاتورة: ' . $e->getMessage());
            return back()->withErrors(['error' => 'حدث خطأ أثناء حذف الفاتورة: ' . $e->getMessage()]);
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
    
    /**
     * تحويل أمر بيع إلى فاتورة مبيعات
     */
    public function convertToInvoice($orderId)
    {
        try {
            DB::beginTransaction();
            
            // 1. جلب بيانات أمر البيع
            $order = DB::table('ot_head')->where('id', $orderId)->first();
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'أمر البيع غير موجود'
                ], 404);
            }
            
            // 2. التحقق من أن النوع هو أمر بيع
            if ($order->pro_tybe != self::INVOICE_TYPES['SALES_ORDER']) {
                return response()->json([
                    'success' => false,
                    'message' => 'هذه ليست أمر بيع'
                ], 400);
            }
            
            // 3. جلب تفاصيل أمر البيع
            $orderDetails = DB::table('fat_details')
                ->where('fat_id', $orderId)
                ->get();
            
            if ($orderDetails->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'أمر البيع لا يحتوي على أصناف'
                ], 400);
            }
            
            // 4. التحقق من توفر المخزون
            $stockErrors = [];
            foreach ($orderDetails as $detail) {
                $item = DB::table('myitems')->where('id', $detail->item_id)->first();
                if ($item && $item->itmqty < $detail->quantity) {
                    $stockErrors[] = "الصنف '{$item->iname}' غير متوفر بالكمية المطلوبة (متوفر: {$item->itmqty}, مطلوب: {$detail->quantity})";
                }
            }
            
            if (!empty($stockErrors)) {
                return response()->json([
                    'success' => false,
                    'message' => "المخزون غير كافي:\n" . implode("\n", $stockErrors)
                ], 400);
            }
            
            // 5. إنشاء فاتورة مبيعات جديدة
            $invoiceId = DB::table('ot_head')->insertGetId([
                'pro_tybe' => self::INVOICE_TYPES['SALES'], // 3 = فاتورة مبيعات
                'pro_date' => $order->pro_date,
                'store_id' => $order->store_id,
                'emp_id' => $order->emp_id,
                'acc1' => $order->acc1,
                'acc2' => $order->acc2,
                'fat_total' => $order->fat_total,
                'fat_disc' => $order->fat_disc,
                'fat_net' => $order->fat_net,
                'info' => 'تم التحويل من أمر بيع #' . $orderId . ($order->info ? ' - ' . $order->info : ''),
                'user' => Auth::id() ?? $order->user,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0
            ]);
            
            Log::info('Invoice created from order', [
                'order_id' => $orderId,
                'invoice_id' => $invoiceId
            ]);
            
            // 6. نسخ التفاصيل وخصم المخزون
            foreach ($orderDetails as $detail) {
                // إضافة التفاصيل للفاتورة الجديدة
                DB::table('fat_details')->insert([
                    'fat_id' => $invoiceId,
                    'item_id' => $detail->item_id,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'total' => $detail->total,
                    'crtime' => now()
                ]);
                
                // خصم المخزون
                DB::table('myitems')
                    ->where('id', $detail->item_id)
                    ->decrement('itmqty', $detail->quantity);
                
                Log::info('Stock decreased (convert)', [
                    'item_id' => $detail->item_id,
                    'qty' => $detail->quantity
                ]);
            }
            
            // 7. حذف أمر البيع (وضع علامة محذوف)
            DB::table('ot_head')
                ->where('id', $orderId)
                ->update([
                    'isdeleted' => 1,
                    'info' => ($order->info ?? '') . ' [تم التحويل لفاتورة #' . $invoiceId . ']',
                    'mdtime' => now()
                ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحويل أمر البيع إلى فاتورة مبيعات بنجاح',
                'invoice_id' => $invoiceId,
                'order_id' => $orderId
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Convert order to invoice error', [
                'order_id' => $orderId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحويل عرض سعر إلى فاتورة مبيعات (مع الاحتفاظ بعرض السعر)
     */
    public function convertQuotationToInvoice($quotationId)
    {
        try {
            DB::beginTransaction();
            
            // 1. جلب بيانات عرض السعر
            $quotation = DB::table('ot_head')->where('id', $quotationId)->first();
            
            if (!$quotation) {
                return response()->json([
                    'success' => false,
                    'message' => 'عرض السعر غير موجود'
                ], 404);
            }
            
            // 2. التحقق من أن النوع هو عرض سعر
            if ($quotation->pro_tybe != self::INVOICE_TYPES['QUOTATION']) {
                return response()->json([
                    'success' => false,
                    'message' => 'هذا ليس عرض سعر'
                ], 400);
            }
            
            // 3. جلب تفاصيل عرض السعر
            $quotationDetails = DB::table('fat_details')
                ->where('fat_id', $quotationId)
                ->get();
            
            if ($quotationDetails->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'عرض السعر لا يحتوي على أصناف'
                ], 400);
            }
            
            // 4. التحقق من توفر المخزون
            $stockErrors = [];
            foreach ($quotationDetails as $detail) {
                $item = DB::table('myitems')->where('id', $detail->item_id)->first();
                if ($item && $item->itmqty < $detail->quantity) {
                    $stockErrors[] = "الصنف '{$item->iname}' غير متوفر بالكمية المطلوبة (متوفر: {$item->itmqty}, مطلوب: {$detail->quantity})";
                }
            }
            
            if (!empty($stockErrors)) {
                return response()->json([
                    'success' => false,
                    'message' => "المخزون غير كافي:\n" . implode("\n", $stockErrors)
                ], 400);
            }
            
            // 5. إنشاء فاتورة مبيعات جديدة
            $invoiceId = DB::table('ot_head')->insertGetId([
                'pro_tybe' => self::INVOICE_TYPES['SALES'], // 3 = فاتورة مبيعات
                'pro_date' => $quotation->pro_date,
                'store_id' => $quotation->store_id,
                'emp_id' => $quotation->emp_id,
                'acc1' => $quotation->acc1,
                'acc2' => $quotation->acc2,
                'fat_total' => $quotation->fat_total,
                'fat_disc' => $quotation->fat_disc,
                'fat_net' => $quotation->fat_net,
                'info' => 'تم التحويل من عرض سعر #' . $quotationId . ($quotation->info ? ' - ' . $quotation->info : ''),
                'user' => Auth::id() ?? $quotation->user,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0
            ]);
            
            Log::info('Invoice created from quotation', [
                'quotation_id' => $quotationId,
                'invoice_id' => $invoiceId
            ]);
            
            // 6. نسخ التفاصيل وخصم المخزون
            foreach ($quotationDetails as $detail) {
                // إضافة التفاصيل للفاتورة الجديدة
                DB::table('fat_details')->insert([
                    'fat_id' => $invoiceId,
                    'item_id' => $detail->item_id,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'total' => $detail->total,
                    'crtime' => now()
                ]);
                
                // خصم المخزون
                DB::table('myitems')
                    ->where('id', $detail->item_id)
                    ->decrement('itmqty', $detail->quantity);
                
                Log::info('Stock decreased (convert quotation)', [
                    'item_id' => $detail->item_id,
                    'qty' => $detail->quantity
                ]);
            }
            
            // 7. تحديث عرض السعر (الاحتفاظ به مع إضافة ملاحظة)
            DB::table('ot_head')
                ->where('id', $quotationId)
                ->update([
                    'info' => ($quotation->info ?? '') . ' [تم التحويل لفاتورة #' . $invoiceId . ']',
                    'mdtime' => now()
                ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحويل عرض السعر إلى فاتورة مبيعات بنجاح',
                'invoice_id' => $invoiceId,
                'quotation_id' => $quotationId
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Convert quotation to invoice error', [
                'quotation_id' => $quotationId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
}
