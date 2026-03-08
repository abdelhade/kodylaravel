<?php

namespace Modules\Mobile\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Get all products with pagination
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 20);
            $search = $request->get('search', '');
            $categoryId = $request->get('category_id');
            $groupId = $request->get('group_id');

            $query = DB::table('myitems')
                ->where('isdeleted', 0)
                ->select(
                    'id',
                    'code',
                    'iname as name',
                    'barcode',
                    'info as description'
                );

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('iname', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('barcode', 'like', "%{$search}%");
                });
            }

            if ($categoryId) {
                $query->where('cat_id', $categoryId);
            }

            if ($groupId) {
                $query->where('group_id', $groupId);
            }

            $items = $query->orderBy('id', 'desc')->paginate($perPage);

            $items->getCollection()->transform(function ($item) {
                $unit = DB::table('item_units')
                    ->where('item_id', $item->id)
                    ->join('myunits', 'item_units.unit_id', '=', 'myunits.id')
                    ->select(
                        'item_units.price1 as wholesale_price',
                        'item_units.price2 as retail_price',
                        'item_units.price3 as market_price',
                        'item_units.cost_price',
                        'myunits.uname as unit_name'
                    )
                    ->first();

                $image = DB::table('imgs')
                    ->where('itemid', $item->id)
                    ->where('isdeleted', 0)
                    ->orderBy('id')
                    ->value('iname');

                $item->prices = $unit ? [
                    'wholesale' => (float) $unit->wholesale_price,
                    'retail' => (float) $unit->retail_price,
                    'market' => (float) $unit->market_price,
                    'cost' => (float) $unit->cost_price,
                ] : null;

                $item->unit_name = $unit->unit_name ?? null;
                $item->image_url = $image ? url('uploads/' . $image) : null;

                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $items->items(),
                'pagination' => [
                    'current_page' => $items->currentPage(),
                    'last_page' => $items->lastPage(),
                    'per_page' => $items->perPage(),
                    'total' => $items->total(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب المنتجات',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single product details
     */
    public function show($id)
    {
        try {
            $item = DB::table('myitems')
                ->where('id', $id)
                ->where('isdeleted', 0)
                ->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود'
                ], 404);
            }

            $units = DB::table('item_units')
                ->where('item_id', $item->id)
                ->join('myunits', 'item_units.unit_id', '=', 'myunits.id')
                ->select(
                    'item_units.id',
                    'item_units.price1 as wholesale_price',
                    'item_units.price2 as retail_price',
                    'item_units.price3 as market_price',
                    'item_units.cost_price',
                    'item_units.u_val as conversion_factor',
                    'myunits.uname as unit_name'
                )
                ->get();

            $images = DB::table('imgs')
                ->where('itemid', $item->id)
                ->where('isdeleted', 0)
                ->get()
                ->map(function($img) {
                    return [
                        'id' => $img->id,
                        'url' => url('uploads/' . $img->iname)
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $item->id,
                    'code' => $item->code,
                    'name' => $item->iname,
                    'barcode' => $item->barcode,
                    'description' => $item->info,
                    'units' => $units,
                    'images' => $images
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب تفاصيل المنتج',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product categories
     */
    public function categories()
    {
        try {
            $categories = DB::table('item_group2')
                ->where('isdeleted', 0)
                ->select('id', 'gname as name')
                ->orderBy('gname')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product groups
     */
    public function groups()
    {
        try {
            $groups = DB::table('item_group')
                ->where('isdeleted', 0)
                ->select('id', 'gname as name')
                ->orderBy('gname')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $groups
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
