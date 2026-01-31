<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    /**
     * Display a listing of stores.
     */
    public function index()
    {
        // Get stores from acc_head where is_stock = 1
        $stores = DB::table('acc_head')
            ->where('is_stock', 1)
            ->where('isdeleted', 0)
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::stores.index', compact('stores', 'settings', 'lang', ));
    }

    /**
     * Show the form for creating a new store.
     */
    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::stores.create', compact('settings', 'lang', ));
    }

    /**
     * Store a newly created store.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $storeName = $request->store;
        
        // Generate account names
        $accbegin = $storeName . ' - أول المدة';
        $accsale = $storeName . ' - مبيعات';
        $accresale = $storeName . ' - مردود مبيعات';
        $accbuy = $storeName . ' - مشتريات';
        $accrebuy = $storeName . ' - مردود مشتريات';
        $accend = $storeName . ' - مخزون حالي ميزانية';

        // Get next code for each account (parent_id = 86)
        $getNextCode = function() {
            $maxCode = DB::table('acc_head')
                ->where('parent_id', 86)
                ->max('code');
            $nextCode = $maxCode ? ($maxCode + 1) : 41101;
            return $nextCode == 1 ? 41101 : $nextCode;
        };

        try {
            DB::beginTransaction();

            // Insert main store account
            $storeId = DB::table('acc_head')->insertGetId([
                'code' => $getNextCode(),
                'aname' => $storeName,
                'is_basic' => 0,
                'rentable' => 0,
                'is_fund' => 0,
                'parent_id' => 86,
                'is_stock' => 1,
                'secret' => 0,
                'kind' => '',
                'isdeleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert related accounts
            $accounts = [
                ['name' => $accbegin, 'code' => $getNextCode()],
                ['name' => $accsale, 'code' => $getNextCode()],
                ['name' => $accresale, 'code' => $getNextCode()],
                ['name' => $accbuy, 'code' => $getNextCode()],
                ['name' => $accrebuy, 'code' => $getNextCode()],
                ['name' => $accend, 'code' => $getNextCode()],
            ];

            foreach ($accounts as $account) {
                DB::table('acc_head')->insert([
                    'code' => $account['code'],
                    'aname' => $account['name'],
                    'is_basic' => 0,
                    'rentable' => 0,
                    'is_fund' => 0,
                    'parent_id' => 86,
                    'is_stock' => 0,
                    'secret' => 0,
                    'kind' => '',
                    'isdeleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Log process
            DB::table('process')->insert([
                'type' => 'add store',
                'created_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('stores.index')
                ->with('success', 'تم إضافة المخزن بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إضافة المخزن: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified store.
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('stores.index')
                ->with('error', 'معرف المخزن مطلوب');
        }

        $store = DB::table('acc_head')
            ->where('id', $id)
            ->where('is_stock', 1)
            ->first();

        if (!$store) {
            return redirect()->route('stores.index')
                ->with('error', 'المخزن غير موجود');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::stores.edit', compact('store', 'settings', 'lang', ));
    }

    /**
     * Update the specified store.
     */
    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المخزن مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'store' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::table('acc_head')
                ->where('id', $id)
                ->where('is_stock', 1)
                ->update([
                    'aname' => $request->store,
                    'updated_at' => now(),
                ]);

            return redirect()->route('stores.index')
                ->with('success', 'تم تحديث المخزن بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء تحديث المخزن: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified store.
     */
    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المخزن مطلوب');
        }

        try {
            DB::table('acc_head')
                ->where('id', $id)
                ->where('is_stock', 1)
                ->update([
                    'isdeleted' => 1,
                    'updated_at' => now(),
                ]);

            return redirect()->route('stores.index')
                ->with('success', 'تم حذف المخزن بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حذف المخزن: ' . $e->getMessage());
        }
    }
}