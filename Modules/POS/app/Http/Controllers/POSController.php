<?php

namespace Modules\POS\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;

class POSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pos::pos.index', compact('settings', 'lang', ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pos::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pos::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pos::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    /**
     * Show basic barcode POS (converted from pos_barcode0.php)
     */
    public function barcodeBasic()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        // Fetch data using raw queries (matching native behavior)
        $stores = \DB::select("SELECT * FROM acc_head WHERE is_stock = 1 AND isdeleted = 0");
        $employees = \DB::select("SELECT * FROM acc_head WHERE parent_id = 35 AND is_basic = 0 AND isdeleted = 0");
        $clients = \DB::select("SELECT * FROM acc_head WHERE code LIKE '122%' AND is_basic = 0 AND isdeleted = 0");
        $funds = \DB::select("SELECT * FROM acc_head WHERE is_fund = 1 AND is_basic = 0 AND isdeleted = 0");
        $categories = \DB::select("SELECT * FROM item_group WHERE isdeleted = 0");
        $items = \DB::select("SELECT * FROM myitems WHERE isdeleted = 0");

        // Convert settings array to object for blade compatibility
        $settingsObj = (object) $settings;

        return view('pos::barcode-basic', [
            'settings' => $settingsObj,
            'lang' => $lang,
            'stores' => $stores,
            'employees' => $employees,
            'clients' => $clients,
            'funds' => $funds,
            'categories' => $categories,
            'items' => $items,
        ]);
    }

    /**
     * Show Purchase Order POS (converted from pos_po.php)
     */
    public function purchaseOrder()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        $stores = \DB::select("SELECT * FROM acc_head WHERE is_stock = 1 AND isdeleted = 0");
        $employees = \DB::select("SELECT * FROM acc_head WHERE parent_id = 35 AND is_basic = 0 AND isdeleted = 0");
        $suppliers = \DB::select("SELECT * FROM acc_head WHERE code LIKE '211%' AND is_basic = 0 AND isdeleted = 0");
        $funds = \DB::select("SELECT * FROM acc_head WHERE is_fund = 1 AND is_basic = 0 AND isdeleted = 0");
        $categories = \DB::select("SELECT * FROM item_group WHERE isdeleted = 0");
        $items = \DB::select("SELECT * FROM myitems WHERE isdeleted = 0");

        $settingsObj = (object) $settings;

        return view('pos::po', [
            'settings' => $settingsObj,
            'lang' => $lang,
            'stores' => $stores,
            'employees' => $employees,
            'suppliers' => $suppliers,
            'funds' => $funds,
            'categories' => $categories,
            'items' => $items,
        ]);
    }

    /**
     * Show Tables POS (converted from pos_tables.php)
     */
    public function tables()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        $stores = \DB::select("SELECT * FROM acc_head WHERE is_stock = 1 AND isdeleted = 0");
        $employees = \DB::select("SELECT * FROM acc_head WHERE parent_id = 35 AND is_basic = 0 AND isdeleted = 0");
        $funds = \DB::select("SELECT * FROM acc_head WHERE is_fund = 1 AND is_basic = 0 AND isdeleted = 0");
        $categories = \DB::select("SELECT * FROM item_group WHERE isdeleted = 0");
        $items = \DB::select("SELECT * FROM myitems WHERE isdeleted = 0");
        $tables = \DB::select("SELECT * FROM tables WHERE isdeleted = 0");

        $settingsObj = (object) $settings;

        return view('pos::tables', [
            'settings' => $settingsObj,
            'lang' => $lang,
            'stores' => $stores,
            'employees' => $employees,
            'funds' => $funds,
            'categories' => $categories,
            'items' => $items,
            'tables' => $tables,
        ]);
    }

    /**
     * Show Time-based POS (converted from pos_time.php)
     */
    public function timeBased()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        $stores = \DB::select("SELECT * FROM acc_head WHERE is_stock = 1 AND isdeleted = 0");
        $employees = \DB::select("SELECT * FROM acc_head WHERE parent_id = 35 AND is_basic = 0 AND isdeleted = 0");
        $clients = \DB::select("SELECT * FROM acc_head WHERE code LIKE '122%' AND is_basic = 0 AND isdeleted = 0");
        $funds = \DB::select("SELECT * FROM acc_head WHERE is_fund = 1 AND is_basic = 0 AND isdeleted = 0");
        $categories = \DB::select("SELECT * FROM item_group WHERE isdeleted = 0");
        $items = \DB::select("SELECT * FROM myitems WHERE isdeleted = 0");
        $tables = \DB::select("SELECT * FROM tables WHERE isdeleted = 0");

        $settingsObj = (object) $settings;

        return view('pos::time', [
            'settings' => $settingsObj,
            'lang' => $lang,
            'stores' => $stores,
            'employees' => $employees,
            'clients' => $clients,
            'funds' => $funds,
            'categories' => $categories,
            'items' => $items,
            'tables' => $tables,
        ]);
    }
}