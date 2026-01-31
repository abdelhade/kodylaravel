<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemStartBalanceController extends Controller
{
    public function index()
    {
        $items = DB::table('myitems')
            ->where('isdeleted', 0)
            ->orderBy('iname')
            ->get();

        // Get unit for each item
        foreach ($items as $item) {
            $unit = DB::table('item_units')
                ->where('item_id', $item->id)
                ->join('myunits', 'item_units.unit_id', '=', 'myunits.id')
                ->select('myunits.uname')
                ->first();
            
            $item->unit_name = $unit->uname ?? '';
            
            // Current start balance = itmqty (current quantity)
            // Current start price = cost_price
            $item->current_start_balance = $item->itmqty ?? 0;
            $item->current_start_price = $item->cost_price ?? 0;
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::items-start-balance.index', compact('items', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|array',
            'item_id.*' => 'required|exists:myitems,id',
            'new_balance' => 'required|array',
            'new_balance.*' => 'nullable|numeric|min:0',
            'new_price' => 'required|array',
            'new_price.*' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update items
        foreach ($request->item_id as $index => $itemId) {
            if (isset($request->new_balance[$index]) && isset($request->new_price[$index])) {
                DB::table('myitems')
                    ->where('id', $itemId)
                    ->update([
                        'itmqty' => $request->new_balance[$index] ?? 0,
                        'cost_price' => $request->new_price[$index] ?? 0,
                        'updated_at' => now(),
                    ]);
            }
        }

        DB::table('process')->insert([
            'type' => 'update items start balance',
            'created_at' => now(),
        ]);

        return redirect()->route('items-start-balance.index')
            ->with('success', 'تم تحديث الأرصدة الافتتاحية بنجاح');
    }

    public function reset(Request $request)
    {
        // Reset all start balances to 0
        DB::table('myitems')
            ->where('isdeleted', 0)
            ->update([
                'itmqty' => 0,
                'cost_price' => 0,
                'updated_at' => now(),
            ]);

        DB::table('process')->insert([
            'type' => 'reset items start balance',
            'created_at' => now(),
        ]);

        return redirect()->route('items-start-balance.index')
            ->with('success', 'تم تصفير جميع الأرصدة الافتتاحية بنجاح');
    }
}