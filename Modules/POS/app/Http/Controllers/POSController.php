<?php

namespace Modules\POS\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\POS\Models\POSTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class POSController extends Controller
{
    /**
     * عرض واجهة نقاط البيع الرئيسية
     */
    public function index()
    {
        // جلب طلبات POS
        $orders = DB::table('ot_head as oh')
            ->select(
                'oh.id',
                'oh.pro_date',
                'oh.fat_total',
                'oh.fat_disc',
                'oh.fat_net',
                'oh.info',
                'oh.crtime',
                'oh.user'
            )
            ->where('oh.pro_tybe', 9)
            ->where('oh.isdeleted', 0)
            ->orderBy('oh.id', 'desc')
            ->paginate(20);

        // جلب تفاصيل كل طلب
        foreach ($orders as $order) {
            $details = DB::table('fat_details as fd')
                ->join('myitems as mi', 'fd.item_id', '=', 'mi.id')
                ->select('fd.quantity', 'fd.price', 'fd.total', 'mi.iname as item_name')
                ->where('fd.fat_id', $order->id)
                ->get();

            $order->items = $details;
            $order->items_count = $details->count();
        }

        return view('pos::pos.index', compact('orders'));
    }

    /**
     * البحث عن صنف بالباركود
     */
    public function searchItem(Request $request)
    {
        $barcode = $request->input('barcode');

        $item = DB::table('acc_head')
            ->where('barcode', $barcode)
            ->orWhere('code', $barcode)
            ->first();

        if (!$item) {
            return response()->json(['error' => 'الصنف غير موجود'], 404);
        }

        return response()->json($item);
    }

    /**
     * إضافة صنف للطلب
     */
    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|numeric|min:0.01',
            'price' => 'required|numeric|min:0',
        ]);

        $item = DB::table('acc_head')->find($validated['item_id']);

        if (!$item) {
            return response()->json(['error' => 'الصنف غير موجود'], 404);
        }

        $total = $validated['quantity'] * $validated['price'];

        return response()->json([
            'item_id' => $item->id,
            'item_name' => $item->aname,
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'total' => $total
        ]);
    }

    /**
     * حفظ الطلب
     */
    public function saveOrder(Request $request)
    {
        \Log::info('POS Save Order Started', ['request_data' => $request->all()]);

        $request->validate([
            'store_id' => 'required|integer',
            'acc2_id' => 'required|integer',
            'fund_id' => 'required|integer',
            'pro_date' => 'required|date',
            'accural_date' => 'required|date',
        ]);

        \Log::info('POS Validation Passed');

        DB::beginTransaction();

        try {

            $orderType = $request->age;
            $storeId = $request->store_id;
            $empId = session('userid') ?? 1; // استخدام المستخدم الحالي
            $clientId = $request->acc2_id;
            $fundId = $request->fund_id;
            $tableId = $request->table_id ?? 0;
            $proDate = $request->pro_date;
            $accuralDate = $request->accural_date;
            $info = $request->info ?? '';
            $editOrderId = $request->edit ?? 0; // معرف الطلب للتعديل

            // الأصناف جاية باسم itmname مش item_id
            $itemIds = $request->itmname ?? [];
            $quantities = $request->itmqty ?? [];
            $prices = $request->itmprice ?? [];
            $uvals = $request->u_val ?? [];

            if (empty($itemIds)) {
                throw new \Exception('يرجى إضافة أصناف للطلب');
            }

            /* ========================
             حساب الإجمالي + تحقق مخزون
             ========================= */

            $total = 0;

            foreach ($itemIds as $index => $itemId) {

                $qty = floatval($quantities[$index] ?? 0);
                $price = floatval($prices[$index] ?? 0);
                $uval = floatval($uvals[$index] ?? 1);

                if ($qty <= 0)
                    continue;

                $requiredQty = $qty * $uval;

                $currentStock = DB::table('myitems')
                    ->where('id', $itemId)
                    ->value('itmqty');

                if ($currentStock === null) {
                    throw new \Exception("الصنف غير موجود بالمخزن");
                }

                // إذا كان تعديل، نسترجع الكمية القديمة أولاً
                if ($editOrderId > 0) {
                    $oldQty = DB::table('fat_details')
                        ->where('fat_id', $editOrderId)
                        ->where('item_id', $itemId)
                        ->value('quantity') ?? 0;
                    
                    $currentStock += $oldQty; // إضافة الكمية القديمة للمخزون
                }

                if ($currentStock < $requiredQty) {
                    throw new \Exception("المخزون غير كافي للصنف رقم {$itemId}");
                }

                $total += ($qty * $price);
            }

            $discount = 0;
            $net = $total - $discount;

            /* ========================
             حفظ أو تحديث رأس الفاتورة
             ========================= */

            if ($editOrderId > 0) {
                // تحديث الطلب الموجود
                DB::table('ot_head')
                    ->where('id', $editOrderId)
                    ->update([
                        'pro_date' => $proDate,
                        'age' => $orderType,
                        'fat_total' => $total,
                        'fat_disc' => $discount,
                        'fat_net' => $net,
                        'info' => $info,
                        'mdtime' => now(),
                    ]);
                
                $orderId = $editOrderId;
                
                // إرجاع المخزون من التفاصيل القديمة
                $oldDetails = DB::table('fat_details')
                    ->where('fat_id', $orderId)
                    ->get();
                
                foreach ($oldDetails as $detail) {
                    DB::table('myitems')
                        ->where('id', $detail->item_id)
                        ->increment('itmqty', $detail->quantity);
                }
                
                // حذف التفاصيل القديمة
                DB::table('fat_details')
                    ->where('fat_id', $orderId)
                    ->delete();
                
            } else {
                // إنشاء طلب جديد
                $orderId = DB::table('ot_head')->insertGetId([
                    'pro_date' => $proDate,
                    'pro_tybe' => 9,
                    'age' => $orderType,
                    'user' => session('userid') ?? 1,
                    'fat_total' => $total,
                    'fat_disc' => $discount,
                    'fat_net' => $net,
                    'info' => $info,
                    'isdeleted' => 0,
                    'crtime' => now(),
                    'mdtime' => now(),
                ]);
            }

            /* ========================
             حفظ التفاصيل + خصم المخزون
             ========================= */

            foreach ($itemIds as $index => $itemId) {

                $qty = floatval($quantities[$index] ?? 0);
                $price = floatval($prices[$index] ?? 0);
                $uval = floatval($uvals[$index] ?? 1);

                if ($qty <= 0)
                    continue;

                $value = $qty * $price;

                DB::table('fat_details')->insert([
                    'fat_id' => $orderId,
                    'item_id' => $itemId,
                    'quantity' => $qty * $uval,
                    'price' => $price,
                    'total' => $value,
                    'crtime' => now(),
                ]);

                // خصم المخزون
                DB::table('myitems')
                    ->where('id', $itemId)
                    ->decrement('itmqty', $qty * $uval);
            }

            /* ========================
             تحديث الطاولة (إذا كانت موجودة)
             ========================= */

            if ($tableId > 0 && $orderType == 2 && DB::getSchemaBuilder()->hasTable('tables')) {
                DB::table('tables')
                    ->where('id', $tableId)
                    ->update(['table_case' => 1]);
            }

            DB::commit();

            \Log::info('POS Order Saved Successfully', [
                'order_id' => $orderId,
                'total' => $net,
                'is_edit' => $editOrderId > 0
            ]);

            $message = $editOrderId > 0 
                ? "تم تعديل الطلب بنجاح - رقم الفاتورة: {$orderId}"
                : "تم حفظ الطلب بنجاح - رقم الفاتورة: {$orderId}";

            return redirect()
                ->route('pos.barcode')
                ->with('success', $message);

        }
        catch (\Exception $e) {

            DB::rollBack();

            \Log::error('POS SAVE ERROR: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * جلب الطلبات السابقة
     */
    public function getRecentOrders(Request $request)
    {
        try {
            $orders = DB::table('ot_head as oh')
                ->select(
                    'oh.id',
                    'oh.pro_date',
                    'oh.age',
                    'oh.fat_total',
                    'oh.fat_disc',
                    'oh.fat_net',
                    'oh.crtime',
                    'oh.info'
                )
                ->where('oh.pro_tybe', 9)
                ->where('oh.isdeleted', 0)
                ->orderBy('oh.id', 'desc')
                ->limit(20)
                ->get();

            // جلب تفاصيل كل طلب
            foreach ($orders as $order) {
                $details = DB::table('fat_details as fd')
                    ->join('myitems as mi', 'fd.item_id', '=', 'mi.id')
                    ->select('fd.item_id', 'mi.iname as item_name', 'fd.quantity', 'fd.price', 'fd.total')
                    ->where('fd.fat_id', $order->id)
                    ->get();

                $order->items = $details;
                $order->items_count = $details->count();
            }

            return response()->json([
                'success' => true,
                'orders' => $orders
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching recent orders: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب الطلبات'
            ], 500);
        }
    }

    /**
     * حذف طلب POS
     */
    public function deleteOrder($id)
    {
        try {
            DB::beginTransaction();

            // التحقق من وجود الطلب
            $order = DB::table('ot_head')
                ->where('id', $id)
                ->where('pro_tybe', 9)
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'الطلب غير موجود'
                ], 404);
            }

            // حذف منطقي (تعيين isdeleted = 1)
            DB::table('ot_head')
                ->where('id', $id)
                ->update(['isdeleted' => 1]);

            // يمكن إضافة إرجاع المخزون هنا إذا لزم الأمر
            $details = DB::table('fat_details')
                ->where('fat_id', $id)
                ->get();

            foreach ($details as $detail) {
                DB::table('myitems')
                    ->where('id', $detail->item_id)
                    ->increment('itmqty', $detail->quantity);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الطلب بنجاح'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting POS order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في حذف الطلب'
            ], 500);
        }
    }

    /**
     * طباعة فاتورة POS
     */
    public function printOrder($id)
    {
        try {
            // جلب بيانات الطلب
            $order = DB::table('ot_head')
                ->where('id', $id)
                ->where('pro_tybe', 9)
                ->where('isdeleted', 0)
                ->first();

            if (!$order) {
                abort(404, 'الطلب غير موجود');
            }

            // جلب تفاصيل الطلب
            $details = DB::table('fat_details as fd')
                ->join('myitems as mi', 'fd.item_id', '=', 'mi.id')
                ->select('mi.iname as item_name', 'fd.quantity', 'fd.price', 'fd.total')
                ->where('fd.fat_id', $id)
                ->get();

            return view('pos::pos.print', compact('order', 'details'));

        } catch (\Exception $e) {
            \Log::error('Error printing POS order: ' . $e->getMessage());
            abort(500, 'حدث خطأ في طباعة الفاتورة');
        }
    }



    /**
     * عرض واجهة POS مع الباركود
     */
    public function barcode(Request $request)
    {
        // جلب البيانات الأساسية
        $posdate = date('Y-m-d', strtotime('-4 hours'));
        $settings = DB::table('settings')->where('id', 1)->first();

        // التحقق من وجود طاولات تجريبية
        $tablesCount = DB::table('tables')->where('isdeleted', 0)->count();
        if ($tablesCount == 0) {
            for ($i = 1; $i <= 12; $i++) {
                DB::table('tables')->insert([
                    'tname' => "طاولة " . $i,
                    'table_case' => 0
                ]);
            }
        }

        // إذا كان هناك معرف للتعديل
        $editOrder = null;
        if ($request->has('edit')) {
            $editOrder = DB::table('ot_head')->where('id', $request->edit)->first();
        }

        // جلب المخازن
        $stores = DB::table('acc_head')
            ->where('is_stock', 1)
            ->where('isdeleted', 0)
            ->get();

        // جلب الموظفين
        $employees = DB::table('acc_head')
            ->where('parent_id', 35)
            ->where('is_basic', 0)
            ->where('isdeleted', 0)
            ->get();

        // جلب العملاء
        $clients = DB::table('acc_head')
            ->where('code', 'like', '122%')
            ->where('is_basic', 0)
            ->where('isdeleted', 0)
            ->get();

        // جلب الصناديق
        $funds = DB::table('acc_head')
            ->where('is_fund', 1)
            ->where('is_basic', 0)
            ->where('isdeleted', 0)
            ->get();

        return view('pos::pos.barcode', compact(
            'posdate',
            'settings',
            'editOrder',
            'stores',
            'employees',
            'clients',
            'funds'
        ));
    }
}
