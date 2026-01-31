<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // This is a complex page, keeping legacy for now
        // Can be converted later with proper invoice handling
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('sales::invoices.index', compact('settings', 'lang', ));
    }

    public function create(Request $request)
    {
        $type = $request->get('q'); // sale, buy, resale, rebuy, po, so
        $invoiceTypes = [
            'sale' => 4,
            'buy' => 3,
            'resale' => 10,
            'rebuy' => 11,
            'po' => 12,
            'so' => 13,
        ];

        $proType = isset($invoiceTypes[$type]) ? $invoiceTypes[$type] : null;
        if (!$proType) {
            return redirect()->route('sales.index')
                ->with('error', 'نوع الفاتورة غير صحيح');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        // Get accounts, items, etc.
        $accounts = DB::table('acc_head')->where('isdeleted', '<', 1)->get();
        $items = DB::table('myitems')->where('isdeleted', 0)->get();

        return view('sales::invoices.create', compact('type', 'proType', 'accounts', 'items', 'settings', 'lang', ));
    }
}