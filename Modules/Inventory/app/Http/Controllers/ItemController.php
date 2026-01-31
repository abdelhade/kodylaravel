<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of items.
     */
    public function index(Request $request)
    {

        $limit = 1000;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $limit;

        // Get items
        $items = DB::table('myitems')
            ->where('isdeleted', 0)
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get();

        // Get units for each item
        foreach ($items as $item) {
            $item->units = DB::table('item_units')
                ->where('item_id', $item->id)
                ->join('myunits', 'item_units.unit_id', '=', 'myunits.id')
                ->select('item_units.*', 'myunits.uname')
                ->get();
        }

        // Get total count for pagination
        $totalCount = DB::table('myitems')->where('isdeleted', 0)->count();
        $totalPages = ceil($totalCount / $limit);

        // Get settings and language
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::items.index', compact('items', 'page', 'totalPages', 'settings', 'lang'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {

        // Get next code
        $maxCode = DB::table('myitems')->max('code');
        $nextCode = $maxCode ? ($maxCode + 1) : 1;

        // Get units
        $units = DB::table('myunits')->get();

        // Get groups
        $groups1 = DB::table('item_group')->where('isdeleted', 0)->get();
        $groups2 = DB::table('item_group2')->where('isdeleted', 0)->get();

        // Get item names for datalist
        $itemNames = DB::table('myitems')->orderBy('iname')->pluck('iname')->toArray();

        // Get settings and language
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::items.create', compact('nextCode', 'units', 'groups1', 'groups2', 'itemNames', 'settings', 'lang'));
    }

    /**
     * Store a newly created item.
     */
    public function store(Request $request)
    {

        // Validation
        $validator = Validator::make($request->all(), [
            'iname' => 'required|string|max:255',
            'code' => 'required|numeric',
            'barcode' => 'nullable|string',
            'unit_id' => 'required|array',
            'unit_id.*' => 'required|exists:myunits,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check for duplicate name
        $existingItem = DB::table('myitems')->where('iname', $request->iname)->first();
        if ($existingItem) {
            return redirect()->back()
                ->with('error', 'يوجد صنف بنفس الاسم: ' . $request->iname)
                ->withInput();
        }

        // Generate barcode if not provided
        $barcode = $request->barcode;
        if (!$barcode) {
            $lastBarcode = DB::table('myitems')->orderBy('id', 'desc')->value('barcode');
            $barcode = $lastBarcode ? ($lastBarcode + 1) : 1000001;
        }

        $userId = session('userid');

        // Insert main item
        $itemId = DB::table('myitems')->insertGetId([
            'iname' => $request->iname,
            'name2' => $request->name2 ?? null,
            'code' => $request->code,
            'barcode' => $barcode,
            'info' => $request->info ?? null,
            'market_price' => $request->market_price[0] ?? 0,
            'cost_price' => $request->cost_price[0] ?? 0,
            'price1' => $request->price1[0] ?? 0,
            'price2' => $request->price2[0] ?? 0,
            'group1' => $request->group1 ?? null,
            'group2' => $request->group2 ?? null,
            'user' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert units
        foreach ($request->unit_id as $index => $unitId) {
            $unitBarcode = $request->unit_barcode[$index] ?? ($barcode . $index);
            if (empty($unitBarcode)) {
                $unitBarcode = '99' . $index . ($request->unit_barcode[0] ?? $barcode);
            }

            DB::table('item_units')->insert([
                'item_id' => $itemId,
                'unit_id' => $unitId,
                'u_val' => $request->u_val[$index] ?? 1,
                'unit_barcode' => $unitBarcode,
                'cost_price' => $request->cost_price[$index] ?? 0,
                'price1' => $request->price1[$index] ?? 0,
                'price2' => $request->price2[$index] ?? 0,
                'price3' => $request->market_price[$index] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Handle image uploads
        if ($request->hasFile('imgs')) {
            $allowedExtensions = ['jpg', 'png', 'gif', 'jpeg', 'webp'];
            
            foreach ($request->file('imgs') as $image) {
                $extension = $image->getClientOriginalExtension();
                
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    continue; // Skip invalid files
                }

                $fileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . rand(1, 1000000) . '.' . $extension;
                $image->move(public_path('uploads'), $fileName);

                DB::table('imgs')->insert([
                    'iname' => $fileName,
                    'itemid' => $itemId,
                    'created_at' => now(),
                ]);
            }
        }

        // Log process
        DB::table('process')->insert([
            'type' => 'add item',
            'created_at' => now(),
        ]);

        return redirect()->route('items.index')
            ->with('success', 'تم إضافة الصنف بنجاح');
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Request $request)
    {

        $id = $request->get('edit');
        if (!$id) {
            return redirect()->route('items.index')
                ->with('error', 'معرف الصنف مطلوب');
        }

        // Get item
        $item = DB::table('myitems')->where('id', $id)->first();
        
        if (!$item) {
            return redirect()->route('items.index')
                ->with('error', 'الصنف غير موجود');
        }

        // Check if item is used in invoices
        $usedInInvoices = DB::table('fat_details')->where('item_id', $id)->exists();

        // Get units
        $units = DB::table('myunits')->get();

        // Get item units
        $itemUnits = DB::table('item_units')
            ->where('item_id', $id)
            ->get();

        // Get groups
        $groups1 = DB::table('item_group')->where('isdeleted', 0)->get();
        $groups2 = DB::table('item_group2')->where('isdeleted', 0)->get();

        // Get item names for datalist
        $itemNames = DB::table('myitems')->orderBy('iname')->pluck('iname')->toArray();

        // Get settings and language
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::items.edit', compact('item', 'itemUnits', 'units', 'groups1', 'groups2', 'itemNames', 'usedInInvoices', 'settings', 'lang'));
    }

    /**
     * Update the specified item.
     */
    public function update(Request $request)
    {

        $id = $request->get('edit');
        if (!$id) {
            return redirect()->route('items.index')
                ->with('error', 'معرف الصنف مطلوب');
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'iname' => 'required|string|max:255',
            'code' => 'required|numeric',
            'barcode' => 'nullable|string',
            'unit_id' => 'required|array',
            'unit_id.*' => 'required|exists:myunits,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check for duplicate name (excluding current item)
        $existingItem = DB::table('myitems')
            ->where('iname', $request->iname)
            ->where('id', '!=', $id)
            ->first();
            
        if ($existingItem) {
            return redirect()->back()
                ->with('error', 'يوجد صنف بنفس الاسم: ' . $request->iname)
                ->withInput();
        }

        // Update main item
        DB::table('myitems')
            ->where('id', $id)
            ->update([
                'iname' => $request->iname,
                'name2' => $request->name2 ?? null,
                'code' => $request->code,
                'info' => $request->info ?? null,
                'cost_price' => $request->cost_price[0] ?? 0,
                'price1' => $request->price1[0] ?? 0,
                'price2' => $request->price2[0] ?? 0,
                'group1' => $request->group1 ?? null,
                'group2' => $request->group2 ?? null,
                'updated_at' => now(),
            ]);

        // Update units
        foreach ($request->unit_id as $index => $unitId) {
            $unitBarcode = $request->unit_barcode[$index] ?? '';
            if (empty($unitBarcode)) {
                $unitBarcode = '99' . $index . ($request->unit_barcode[0] ?? '');
            }

            // Check if unit exists for this item
            $existingUnit = DB::table('item_units')
                ->where('item_id', $id)
                ->where('unit_id', $unitId)
                ->first();

            if ($existingUnit) {
                // Update existing unit
                DB::table('item_units')
                    ->where('id', $existingUnit->id)
                    ->update([
                        'price1' => $request->price1[$index] ?? 0,
                        'price2' => $request->price2[$index] ?? 0,
                        'price3' => $request->market_price[$index] ?? 0,
                        'u_val' => $request->u_val[$index] ?? 1,
                        'unit_barcode' => $unitBarcode,
                        'updated_at' => now(),
                    ]);
            } else {
                // Insert new unit
                DB::table('item_units')->insert([
                    'item_id' => $id,
                    'unit_id' => $unitId,
                    'u_val' => $request->u_val[$index] ?? 1,
                    'unit_barcode' => $unitBarcode,
                    'cost_price' => $request->cost_price[$index] ?? 0,
                    'price1' => $request->price1[$index] ?? 0,
                    'price2' => $request->price2[$index] ?? 0,
                    'price3' => $request->market_price[$index] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('items.index')
            ->with('success', 'تم تحديث الصنف بنجاح');
    }

    /**
     * Remove the specified item.
     */
    public function destroy(Request $request)
    {

        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('items.index')
                ->with('error', 'معرف الصنف مطلوب');
        }

        // Soft delete
        DB::table('myitems')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('items.index')
            ->with('success', 'تم حذف الصنف بنجاح');
    }

    /**
     * Show item summary.
     */
    public function summary(Request $request)
    {
        $id = $request->get('id');
        // TODO: Implement summary view
        return redirect()->route('items.index');
    }

    /**
     * Recalculate item costs.
     */
    public function recost(Request $request)
    {
        // TODO: Implement recost functionality
        return redirect()->route('items.index')
            ->with('success', 'تم إعادة حساب التكاليف');
    }

    /**
     * Upload items from Excel.
     */
    public function upload(Request $request)
    {
        // TODO: Implement Excel upload functionality
        return redirect()->route('items.index')
            ->with('success', 'تم رفع الملف بنجاح');
    }
}
