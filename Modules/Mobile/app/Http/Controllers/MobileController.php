<?php

namespace Modules\Mobile\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Support\Facades\DB;

class MobileController extends Controller
{
    /**
     * عرض المنتجات للموبايل
     */
    public function index()
    {
        // جلب المنتجات
        $items = DB::table('myitems')
            ->where('isdeleted', 0)
            ->select('id', 'code', 'iname as name', 'barcode', 'info as description')
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();

        // جلب السعر والصورة لكل منتج
        foreach ($items as $item) {
            // السعر
            $unit = DB::table('item_units')
                ->where('item_id', $item->id)
                ->join('myunits', 'item_units.unit_id', '=', 'myunits.id')
                ->select('item_units.price3 as price', 'myunits.uname as unit')
                ->first();
            
            $item->price = $unit->price ?? 0;
            $item->unit = $unit->unit ?? '';
            
            // الصورة
            $image = DB::table('imgs')
                ->where('itemid', $item->id)
                ->where('isdeleted', 0)
                ->orderBy('id')
                ->value('iname');
            
            $item->image = $image ? asset('uploads/' . $image) : null;
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('mobile::index', compact('items', 'settings', 'lang'));
    }
}
