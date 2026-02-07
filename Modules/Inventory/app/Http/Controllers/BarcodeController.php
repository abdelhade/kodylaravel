<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarcodeController extends Controller
{
    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::barcode.index', compact('settings', 'lang'));
    }

    public function pricePublic(Request $request)
    {
        $barcode = $request->get('barcode');

        if (!$barcode) {
            return response()->json(['iname' => null, 'price1' => null]);
        }

        $item = DB::table('myitems')
            ->select('iname', 'price1')
            ->where('barcode', $barcode)
            ->first();

        if (!$item) {
            return response()->json(['iname' => null, 'price1' => null]);
        }

        return response()->json([
            'iname' => $item->iname,
            'price1' => $item->price1
        ]);
    }
}


