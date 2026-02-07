<?php

namespace Modules\Purchases\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('purchases::index', compact('settings', 'lang'));
    }

    public function sales(Request $request)
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        $type = $request->get('q', 'sale');
        
        return view('purchases::sales', compact('settings', 'lang', 'type'));
    }

    public function create(Request $request)
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        $type = $request->get('q', 'buy');
        
        return view('purchases::create', compact('settings', 'lang', 'type'));
    }

    public function edit(Request $request)
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        $id = $request->get('e');
        $invoice = DB::table('ot_head')->where('id', $id)->first();
        
        return view('purchases::edit', compact('settings', 'lang', 'invoice'));
    }

    public function posBarcode()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('purchases::pos-barcode', compact('settings', 'lang'));
    }

    public function posPo()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('purchases::pos-po', compact('settings', 'lang'));
    }

    public function crudTables()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('purchases::crud-tables', compact('settings', 'lang'));
    }

    public function closedSessions()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('purchases::closed-sessions', compact('settings', 'lang'));
    }

    public function addVoucher(Request $request)
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        $type = $request->get('t', 'recive');
        
        return view('purchases::add-voucher', compact('settings', 'lang', 'type'));
    }

    public function vouchers()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('purchases::vouchers', compact('settings', 'lang'));
    }

    public function salesReports()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('purchases::sales-reports', compact('settings', 'lang'));
    }

    public function operationsSummary(Request $request)
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        $type = $request->get('q', 'sale');
        
        return view('purchases::operations-summary', compact('settings', 'lang', 'type'));
    }

    public function itemsSummary()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('purchases::items-summary', compact('settings', 'lang'));
    }
}