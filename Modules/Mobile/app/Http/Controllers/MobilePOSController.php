<?php

namespace Modules\Mobile\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobilePOSController extends Controller
{
    /**
     * عرض واجهة نقطة البيع المتنقلة
     */
    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        // جلب المخازن
        $stores = DB::table('acc_head')
            ->where('is_stock', 1)
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

        return view('mobile::pos.index', compact('settings', 'lang', 'stores', 'clients', 'funds'));
    }

    /**
     * البحث عن منتج بالباركود أو الاسم
     */
    public function searchProduct(Request $request)
    {
        $search = $request->input('search');

        $item = DB::table('myitems')
            ->where('isdeleted', 0)
            ->where(function($query) use ($search) {
                $query->where('barcode', $search)
                      ->orWhere('code', $search)
                      ->orWhere('iname', 'like', '%' . $search . '%');
            })
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ]);
        }

        // جلب السعر والوحدة
        $unit = DB::table('item_units')
            ->where('item_id', $item->id)
            ->join('myunits', 'item_units.unit_id', '=', 'myunits.id')
            ->select('item_units.price3 as price', 'myunits.uname as unit', 'item_units.u_val')
            ->first();

        // جلب الصورة
        $image = DB::table('imgs')
            ->where('itemid', $item->id)
            ->where('isdeleted', 0)
            ->orderBy('id')
            ->value('iname');

        return response()->json([
            'success' => true,
            'item' => [
                'id' => $item->id,
                'name' => $item->iname,
                'code' => $item->code,
                'barcode' => $item->barcode,
                'price' => $unit->price ?? 0,
                'unit' => $unit->unit ?? '',
                'u_val' => $unit->u_val ?? 1,
                'stock' => $item->itmqty ?? 0,
                'image' => $image ? asset('uploads/' . $image) : null
            ]
        ]);
    }

    /**
     * حفظ الفاتورة
     */
    public function saveInvoice(Request $request)
    {
        DB::beginTransaction();

        try {
            $storeId = $request->store_id;
            $clientId = $request->client_id;
            $fundId = $request->fund_id;
            $items = json_decode($request->items, true);
            $discount = floatval($request->discount ?? 0);
            $proDate = now()->format('Y-m-d');

            if (empty($items)) {
                throw new \Exception('يرجى إضافة منتجات للفاتورة');
            }

            // حساب الإجمالي
            $total = 0;
            foreach ($items as $item) {
                $qty = floatval($item['quantity']);
                $price = floatval($item['price']);
                $uval = floatval($item['u_val'] ?? 1);
                
                // التحقق من المخزون
                $currentStock = DB::table('myitems')
                    ->where('id', $item['id'])
                    ->value('itmqty');

                $requiredQty = $qty * $uval;

                if ($currentStock < $requiredQty) {
                    $settings = DB::table('settings')->where('id', 1)->first();
                    $allowNegativeStock = $settings->allow_negative_stock ?? 0;
                    
                    if (!$allowNegativeStock) {
                        throw new \Exception("المخزون غير كافي للمنتج: {$item['name']}");
                    }
                }

                $total += ($qty * $price);
            }

            $net = $total - $discount;

            // حفظ رأس الفاتورة
            $orderId = DB::table('ot_head')->insertGetId([
                'pro_date' => $proDate,
                'pro_tybe' => 9,
                'age' => 1, // نقدي
                'acc1' => $clientId,
                'acc2' => $storeId,
                'store_id' => $storeId,
                'emp_id' => session('userid') ?? 1,
                'acc_fund' => $fundId,
                'user' => session('userid') ?? 1,
                'fat_total' => $total,
                'fat_disc' => $discount,
                'fat_net' => $net,
                'info' => 'فاتورة موبايل',
                'isdeleted' => 0,
                'crtime' => now(),
                'mdtime' => now(),
            ]);

            // حفظ التفاصيل وخصم المخزون
            foreach ($items as $item) {
                $qty = floatval($item['quantity']);
                $price = floatval($item['price']);
                $uval = floatval($item['u_val'] ?? 1);
                $value = $qty * $price;

                DB::table('fat_details')->insert([
                    'fat_id' => $orderId,
                    'item_id' => $item['id'],
                    'quantity' => $qty * $uval,
                    'price' => $price,
                    'total' => $value,
                    'crtime' => now(),
                ]);

                // خصم المخزون
                DB::table('myitems')
                    ->where('id', $item['id'])
                    ->decrement('itmqty', $qty * $uval);
            }

            // القيد المحاسبي
            $maxJournalId = DB::table('journal_heads')->max('journal_id') ?? 0;
            $journalId = $maxJournalId + 1;
            
            $journalHeadId = DB::table('journal_heads')->insertGetId([
                'journal_id' => $journalId,
                'total' => $net,
                'jdate' => $proDate,
                'details' => 'فاتورة موبايل _ ' . $orderId,
                'user' => session('userid') ?? 1,
                'op_id' => $orderId,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0,
            ]);
            
            // مدين - العميل
            DB::table('journal_entries')->insert([
                'journal_id' => $journalHeadId,
                'account_id' => $clientId,
                'debit' => $net,
                'credit' => 0,
                'tybe' => 0,
                'op_id' => $orderId,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0,
            ]);
            
            // دائن - المخزن
            DB::table('journal_entries')->insert([
                'journal_id' => $journalHeadId,
                'account_id' => $storeId,
                'debit' => 0,
                'credit' => $net,
                'tybe' => 1,
                'op_id' => $orderId,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0,
            ]);

            // قيد الدفع النقدي
            $journalId2 = $journalId + 1;
            
            $journalHeadId2 = DB::table('journal_heads')->insertGetId([
                'journal_id' => $journalId2,
                'total' => $net,
                'jdate' => $proDate,
                'details' => 'سند قبض موبايل _ ' . $orderId,
                'user' => session('userid') ?? 1,
                'op_id' => $orderId,
                'op2' => $orderId,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0,
            ]);
            
            // مدين - الصندوق
            DB::table('journal_entries')->insert([
                'journal_id' => $journalHeadId2,
                'account_id' => $fundId,
                'debit' => $net,
                'credit' => 0,
                'tybe' => 0,
                'op_id' => $orderId,
                'op2' => $orderId,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0,
            ]);
            
            // دائن - العميل
            DB::table('journal_entries')->insert([
                'journal_id' => $journalHeadId2,
                'account_id' => $clientId,
                'debit' => 0,
                'credit' => $net,
                'tybe' => 1,
                'op_id' => $orderId,
                'op2' => $orderId,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0,
            ]);

            // تحديث الأرصدة
            DB::statement("
                UPDATE acc_head 
                SET balance = (
                    SELECT COALESCE(SUM(journal_entries.debit) - SUM(journal_entries.credit), 0) 
                    FROM journal_entries 
                    WHERE journal_entries.account_id = acc_head.id 
                    AND journal_entries.isdeleted = 0
                )
                WHERE id IN (?, ?, ?)
            ", [$clientId, $storeId, $fundId]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم حفظ الفاتورة بنجاح',
                'invoice_id' => $orderId
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
