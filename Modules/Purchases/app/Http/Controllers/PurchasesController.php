<?php

namespace Modules\Purchases\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchasesController extends Controller
{
    // تعريف ثوابت أنواع الفواتير
    const INVOICE_TYPES = [
        'PURCHASE' => 4,           // مشتريات
        'SALES' => 3,              // مبيعات  
        'PURCHASE_ORDER' => 12,    // أمر شراء (الرقم الصحيح)
        'SALES_ORDER' => 13,       // أمر بيع
        'POS' => 9,                // كاشير
        'PURCHASE_RETURN' => 11,   // مردود مشتريات (الرقم الصحيح)
        'SALES_RETURN' => 10       // مردود مبيعات
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
        $from_date = $request->input('from_date', date('Y-m-01'));
        $to_date = $request->input('to_date', date('Y-m-d'));
        $invoice_type = $request->input('invoice_type', 'all'); // فلتر نوع الفاتورة
        
        $query = DB::table('ot_head as h')
            ->leftJoin('users as u', 'h.user', '=', 'u.id')
            ->leftJoin('acc_head as a1', 'h.acc1', '=', 'a1.id')
            ->leftJoin('acc_head as a2', 'h.acc2', '=', 'a2.id')
            ->where('h.isdeleted', 0)
            ->whereBetween('h.pro_date', [$from_date, $to_date]);
        
        // تطبيق فلتر نوع الفاتورة
        if ($invoice_type === 'all') {
            $query->whereIn('h.pro_tybe', [
                self::INVOICE_TYPES['PURCHASE'],
                self::INVOICE_TYPES['PURCHASE_RETURN'],
                self::INVOICE_TYPES['PURCHASE_ORDER']
            ]);
        } elseif ($invoice_type === 'purchase') {
            $query->where('h.pro_tybe', self::INVOICE_TYPES['PURCHASE']);
        } elseif ($invoice_type === 'order') {
            $query->where('h.pro_tybe', self::INVOICE_TYPES['PURCHASE_ORDER']);
        } elseif ($invoice_type === 'return') {
            $query->where('h.pro_tybe', self::INVOICE_TYPES['PURCHASE_RETURN']);
        }
        
        $invoices = $query->select(
                'h.*',
                'u.uname as user_name',
                'a1.aname as acc1_name',
                'a2.aname as acc2_name'
            )
            ->orderBy('h.id', 'desc')
            ->paginate(20);

        // تحويل pro_tybe إلى integer للتأكد من المقارنة الصحيحة
        $invoices->getCollection()->transform(function ($invoice) {
            $invoice->pro_tybe = (int) $invoice->pro_tybe;
            return $invoice;
        });

        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();

        return view('purchases::invoices.index', compact('invoices', 'settings', 'lang', 'invoice_type'));
    }

    /**
     * عرض صفحة فاتورة المشتريات
     */
    public function purchaseInvoice()
    {
        $pro_tybe = self::INVOICE_TYPES['PURCHASE'];
        $invoice_title = 'فاتورة مشتريات';
        $is_edit_mode = false;
        
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::invoices.purchase', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'settings', 'lang'));
    }

    /**
     * عرض صفحة مردود المشتريات
     */
    public function purchaseReturn()
    {
        $pro_tybe = self::INVOICE_TYPES['PURCHASE_RETURN'];
        $invoice_title = 'فاتورة مردود مشتريات';
        $is_edit_mode = false;
        
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::invoices.purchase', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'settings', 'lang'));
    }

    /**
     * عرض صفحة أمر الشراء
     */
    public function purchaseOrder()
    {
        $pro_tybe = self::INVOICE_TYPES['PURCHASE_ORDER'];
        $invoice_title = 'أمر شراء';
        $is_edit_mode = false;
        $is_purchase_order = true; // علامة لتمييز أمر الشراء
        
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::invoices.purchase', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'is_purchase_order', 'settings', 'lang'));
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

    /**
     * عرض صفحة تعديل الفاتورة
     */
    public function edit($id)
    {
        $invoice = DB::table('ot_head')->where('id', $id)->where('isdeleted', 0)->first();
        
        if (!$invoice) {
            return redirect()->route('purchases.index')->with('error', 'الفاتورة غير موجودة');
        }

        $pro_tybe = (int) $invoice->pro_tybe;
        $invoice_title = 'تعديل فاتورة المشتريات';
        $is_edit_mode = true;
        $invoice_data = $invoice;
        
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::invoices.purchase', compact('pro_tybe', 'invoice_title', 'is_edit_mode', 'invoice_data', 'settings', 'lang'));
    }

    /**
     * إضافة فاتورة مشتريات جديدة
     */
    public function store(Request $request)
    {
        try {
            Log::info('Purchase Invoice Store Request', [
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
                
                // تحديث المخزون حسب نوع الفاتورة
                // أمر الشراء (نوع 8) لا يؤثر على المخزون
                if ($pro_tybe == self::INVOICE_TYPES['PURCHASE']) {
                    // مشتريات: زيادة الكمية
                    DB::table('myitems')
                        ->where('id', $item_id)
                        ->increment('itmqty', $qty);
                } elseif ($pro_tybe == self::INVOICE_TYPES['PURCHASE_RETURN']) {
                    // مردود مشتريات: تقليل الكمية
                    DB::table('myitems')
                        ->where('id', $item_id)
                        ->decrement('itmqty', $qty);
                } elseif ($pro_tybe == self::INVOICE_TYPES['PURCHASE_ORDER']) {
                    // أمر شراء: لا يؤثر على المخزون
                    Log::info('Purchase Order created - No inventory update', ['order_id' => $last_op]);
                }
                
                $itemsInserted++;
            }
            
            Log::info('Invoice details inserted', ['count' => $itemsInserted]);

            if ($itemsInserted == 0) {
                throw new \Exception('يجب إضافة صنف واحد على الأقل');
            }

            /* ========================
             إنشاء القيد المحاسبي
             ========================= */
            
            // فقط للفواتير الفعلية (مشتريات ومردودات)
            if (in_array($pro_tybe, [self::INVOICE_TYPES['PURCHASE'], self::INVOICE_TYPES['PURCHASE_RETURN']])) {
                // الحصول على رقم القيد التالي
                $maxJournalId = DB::table('journal_heads')->max('journal_id') ?? 0;
                $journalId = $maxJournalId + 1;
                
                // تحديد نوع القيد
                $journalDetails = $pro_tybe == self::INVOICE_TYPES['PURCHASE_RETURN'] 
                    ? 'مردود مشتريات _ ' . $last_op 
                    : 'فاتورة مشتريات _ ' . $last_op;
                
                // إنشاء رأس القيد
                $journalHeadId = DB::table('journal_heads')->insertGetId([
                    'journal_id' => $journalId,
                    'total' => $headnet,
                    'jdate' => $pro_date,
                    'details' => $journalDetails,
                    'user' => Auth::id() ?? 1,
                    'op_id' => $last_op,
                    'crtime' => now(),
                    'mdtime' => now(),
                    'isdeleted' => 0,
                ]);
                
                if ($pro_tybe == self::INVOICE_TYPES['PURCHASE_RETURN']) {
                    // مردود مشتريات: عكس القيد
                    // من حـ/ المورد (مدين)
                    DB::table('journal_entries')->insert([
                        'journal_id' => $journalHeadId,
                        'account_id' => $acc2_id,
                        'debit' => $headnet,
                        'credit' => 0,
                        'tybe' => 0,
                        'op_id' => $last_op,
                        'crtime' => now(),
                        'mdtime' => now(),
                        'isdeleted' => 0,
                    ]);
                    
                    // إلى حـ/ المخزن (دائن)
                    DB::table('journal_entries')->insert([
                        'journal_id' => $journalHeadId,
                        'account_id' => $store_id,
                        'debit' => 0,
                        'credit' => $headnet,
                        'tybe' => 1,
                        'op_id' => $last_op,
                        'crtime' => now(),
                        'mdtime' => now(),
                        'isdeleted' => 0,
                    ]);
                } else {
                    // مشتريات عادية
                    // من حـ/ المخزن (مدين)
                    DB::table('journal_entries')->insert([
                        'journal_id' => $journalHeadId,
                        'account_id' => $store_id,
                        'debit' => $headnet,
                        'credit' => 0,
                        'tybe' => 0,
                        'op_id' => $last_op,
                        'crtime' => now(),
                        'mdtime' => now(),
                        'isdeleted' => 0,
                    ]);
                    
                    // إلى حـ/ المورد (دائن)
                    DB::table('journal_entries')->insert([
                        'journal_id' => $journalHeadId,
                        'account_id' => $acc2_id,
                        'debit' => 0,
                        'credit' => $headnet,
                        'tybe' => 1,
                        'op_id' => $last_op,
                        'crtime' => now(),
                        'mdtime' => now(),
                        'isdeleted' => 0,
                    ]);
                }
                
                // تحديث أرصدة الحسابات
                DB::statement("
                    UPDATE acc_head 
                    SET balance = (
                        SELECT COALESCE(SUM(journal_entries.debit) - SUM(journal_entries.credit), 0) 
                        FROM journal_entries 
                        WHERE journal_entries.account_id = acc_head.id 
                        AND journal_entries.isdeleted = 0
                    )
                    WHERE id IN (?, ?)
                ", [$acc2_id, $store_id]);
            }

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'تم حفظ الفاتورة بنجاح - رقم: ' . $last_op);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase Invoice Store Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * تحديث فاتورة المشتريات
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Purchase Invoice Update Request', [
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

            // إرجاع المخزون من التفاصيل القديمة (إلا إذا كان أمر شراء)
            $oldDetails = DB::table('fat_details')
                ->where('fat_id', $id)
                ->get();
            
            foreach ($oldDetails as $detail) {
                if ($pro_tybe == self::INVOICE_TYPES['PURCHASE']) {
                    // مشتريات: نرجع بالتقليل
                    DB::table('myitems')
                        ->where('id', $detail->item_id)
                        ->decrement('itmqty', $detail->quantity);
                } elseif ($pro_tybe == self::INVOICE_TYPES['PURCHASE_RETURN']) {
                    // مردود مشتريات: نرجع بالزيادة
                    DB::table('myitems')
                        ->where('id', $detail->item_id)
                        ->increment('itmqty', $detail->quantity);
                } elseif ($pro_tybe == self::INVOICE_TYPES['PURCHASE_ORDER']) {
                    // أمر شراء: لا يؤثر على المخزون
                    Log::info('Purchase Order update - No inventory rollback needed', ['order_id' => $id]);
                }
            }

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
                
                // تحديث المخزون حسب نوع الفاتورة (أمر الشراء لا يؤثر)
                if ($pro_tybe == self::INVOICE_TYPES['PURCHASE']) {
                    // مشتريات: زيادة الكمية
                    DB::table('myitems')
                        ->where('id', $item_id)
                        ->increment('itmqty', $qty);
                } elseif ($pro_tybe == self::INVOICE_TYPES['PURCHASE_RETURN']) {
                    // مردود مشتريات: تقليل الكمية
                    DB::table('myitems')
                        ->where('id', $item_id)
                        ->decrement('itmqty', $qty);
                } elseif ($pro_tybe == self::INVOICE_TYPES['PURCHASE_ORDER']) {
                    // أمر شراء: لا يؤثر على المخزون
                    Log::info('Purchase Order updated - No inventory update', ['order_id' => $id]);
                }
                
                $itemsInserted++;
            }
            
            Log::info('Invoice details updated', ['count' => $itemsInserted]);

            if ($itemsInserted == 0) {
                throw new \Exception('يجب إضافة صنف واحد على الأقل');
            }

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'تم تحديث الفاتورة بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase Invoice Update Error', [
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
            
            // إرجاع المخزون من التفاصيل (إلا إذا كان أمر شراء)
            $details = DB::table('fat_details')
                ->where('fat_id', $id)
                ->get();
            
            foreach ($details as $detail) {
                if ($invoice->pro_tybe == self::INVOICE_TYPES['PURCHASE']) {
                    // مشتريات: نرجع بالتقليل
                    DB::table('myitems')
                        ->where('id', $detail->item_id)
                        ->decrement('itmqty', $detail->quantity);
                } elseif ($invoice->pro_tybe == self::INVOICE_TYPES['PURCHASE_RETURN']) {
                    // مردود مشتريات: نرجع بالزيادة
                    DB::table('myitems')
                        ->where('id', $detail->item_id)
                        ->increment('itmqty', $detail->quantity);
                } elseif ($invoice->pro_tybe == self::INVOICE_TYPES['PURCHASE_ORDER']) {
                    // أمر شراء: لا يؤثر على المخزون
                    Log::info('Purchase Order deleted - No inventory rollback needed', ['order_id' => $id]);
                }
            }
            
            // حذف الفاتورة والتفاصيل
            DB::table('ot_head')->where('id', $id)->update(['isdeleted' => 1]);
            DB::table('fat_details')->where('fat_id', $id)->delete();

            DB::commit();
            
            return redirect()->route('purchases.index')->with('success', 'تم حذف الفاتورة بنجاح');
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
     * تحويل أمر شراء إلى فاتورة مشتريات
     */
    public function convertToInvoice($id)
    {
        try {
            DB::beginTransaction();
            
            // التحقق من أن الطلب هو أمر شراء
            $order = DB::table('ot_head')->where('id', $id)->where('isdeleted', 0)->first();
            
            if (!$order) {
                throw new \Exception('أمر الشراء غير موجود');
            }
            
            if ($order->pro_tybe != self::INVOICE_TYPES['PURCHASE_ORDER']) {
                throw new \Exception('هذا ليس أمر شراء');
            }
            
            // التحقق من أنه لم يتم تحويله مسبقاً
            if (!empty($order->converted_to_invoice)) {
                throw new \Exception('تم تحويل هذا الأمر مسبقاً');
            }
            
            // تحديث حالة الأمر - نضيف علامة التحويل فقط
            DB::table('ot_head')->where('id', $id)->update([
                'converted_to_invoice' => 1,
                'converted_at' => now(),
                'mdtime' => now()
            ]);
            
            // تحديث المخزون بناءً على التفاصيل
            $details = DB::table('fat_details')->where('fat_id', $id)->get();
            
            foreach ($details as $detail) {
                DB::table('myitems')
                    ->where('id', $detail->item_id)
                    ->increment('itmqty', $detail->quantity);
            }
            
            Log::info('Purchase Order converted to Invoice', [
                'order_id' => $id,
                'items_count' => $details->count()
            ]);
            
            DB::commit();
            
            return redirect()->route('purchases.index')->with('success', 'تم تحويل أمر الشراء إلى فاتورة مشتريات بنجاح');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Convert Purchase Order Error', [
                'message' => $e->getMessage(),
                'order_id' => $id
            ]);
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
}
