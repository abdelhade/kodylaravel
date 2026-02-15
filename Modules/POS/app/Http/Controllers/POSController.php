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
        $tables = POSTable::active()->get();
        $stores = DB::table('acc_head')
            ->where('is_stock', 1)
            ->where('isdeleted', 0)
            ->get();
        $employees = DB::table('acc_head')
            ->where('parent_id', 35)
            ->where('is_basic', 0)
            ->get();
        $customers = DB::table('acc_head')
            ->where('code', 'like', '122%')
            ->get();
        $funds = DB::table('acc_head')
            ->where('is_fund', 1)
            ->get();

        return view('pos::index', compact('tables', 'stores', 'employees', 'customers', 'funds'));
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
        $validated = $request->validate([
            'table_id' => 'nullable|integer',
            'order_type' => 'required|in:1,2,3', // 1=تيك أواي، 2=طاولة، 3=دليفري
            'items' => 'required|array',
            'total' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // إنشاء الطلب
            $orderId = DB::table('ot_head')->insertGetId([
                'pro_date' => now()->toDateString(),
                'pro_tybe' => 9, // POS
                'user' => auth()->id(),
                'fat_total' => $validated['total'],
                'fat_disc' => $validated['discount'] ?? 0,
                'fat_net' => $validated['total'] - ($validated['discount'] ?? 0),
                'info' => $validated['notes'] ?? '',
                'isdeleted' => 0,
                'crtime' => now(),
                'mdtime' => now(),
            ]);

            // إضافة تفاصيل الطلب
            foreach ($validated['items'] as $item) {
                DB::table('fat_details')->insert([
                    'fat_id' => $orderId,
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                    'crtime' => now(),
                ]);
            }

            // تحديث حالة الطاولة إذا كانت موجودة
            if ($validated['table_id']) {
                POSTable::find($validated['table_id'])->update(['table_case' => 1]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $orderId,
                'message' => 'تم حفظ الطلب بنجاح'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
