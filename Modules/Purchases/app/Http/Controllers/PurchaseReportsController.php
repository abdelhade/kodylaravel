<?php

namespace Modules\Purchases\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReportsController extends Controller
{
    public function index()
    {
        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::reports.index', compact('settings', 'lang'));
    }

    public function dailyReport(Request $request)
    {
        $from_date = $request->input('from_date', date('Y-m-d'));
        $to_date = $request->input('to_date', date('Y-m-d'));
        
        $purchases = DB::table('ot_head as h')
            ->leftJoin('fat_details as d', 'h.id', '=', 'd.fatid')
            ->leftJoin('myitems as i', 'd.item_id', '=', 'i.id')
            ->where('h.isdeleted', 0)
            ->where('h.pro_tybe', 4)
            ->whereBetween('h.pro_date', [$from_date, $to_date])
            ->select(
                'h.id',
                'h.pro_date',
                'h.info',
                'h.fat_total',
                'h.fat_disc',
                'h.fat_net',
                DB::raw('GROUP_CONCAT(i.itmname SEPARATOR ", ") as items')
            )
            ->groupBy('h.id', 'h.pro_date', 'h.info', 'h.fat_total', 'h.fat_disc', 'h.fat_net')
            ->orderBy('h.pro_date', 'desc')
            ->get();

        $totals = [
            'total' => $purchases->sum('fat_total'),
            'discount' => $purchases->sum('fat_disc'),
            'net' => $purchases->sum('fat_net'),
            'count' => $purchases->count()
        ];

        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::reports.daily', compact('purchases', 'totals', 'from_date', 'to_date', 'settings', 'lang'));
    }

    public function itemsReport(Request $request)
    {
        $from_date = $request->input('from_date', date('Y-m-01'));
        $to_date = $request->input('to_date', date('Y-m-d'));
        
        $items = DB::table('fat_details as d')
            ->join('ot_head as h', 'd.fatid', '=', 'h.id')
            ->join('myitems as i', 'd.item_id', '=', 'i.id')
            ->where('h.isdeleted', 0)
            ->where('h.pro_tybe', 4)
            ->whereBetween('h.pro_date', [$from_date, $to_date])
            ->select(
                'i.id',
                'i.itmname',
                'i.barcode',
                DB::raw('SUM(d.quantity) as total_qty'),
                DB::raw('AVG(d.price) as avg_price'),
                DB::raw('SUM(d.total) as total_amount'),
                DB::raw('COUNT(DISTINCT h.id) as invoice_count')
            )
            ->groupBy('i.id', 'i.itmname', 'i.barcode')
            ->orderBy('total_amount', 'desc')
            ->get();

        $totals = [
            'total_qty' => $items->sum('total_qty'),
            'total_amount' => $items->sum('total_amount'),
            'items_count' => $items->count()
        ];

        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::reports.items', compact('items', 'totals', 'from_date', 'to_date', 'settings', 'lang'));
    }

    public function suppliersReport(Request $request)
    {
        $from_date = $request->input('from_date', date('Y-m-01'));
        $to_date = $request->input('to_date', date('Y-m-d'));
        
        $suppliers = DB::table('ot_head')
            ->where('isdeleted', 0)
            ->where('pro_tybe', 4)
            ->whereBetween('pro_date', [$from_date, $to_date])
            ->select(
                DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(info, "المورد:", -1), "\n", 1) as supplier_name'),
                DB::raw('COUNT(*) as invoice_count'),
                DB::raw('SUM(fat_total) as total_amount'),
                DB::raw('SUM(fat_disc) as total_discount'),
                DB::raw('SUM(fat_net) as total_net')
            )
            ->groupBy('supplier_name')
            ->orderBy('total_net', 'desc')
            ->get();

        $totals = [
            'invoice_count' => $suppliers->sum('invoice_count'),
            'total_amount' => $suppliers->sum('total_amount'),
            'total_discount' => $suppliers->sum('total_discount'),
            'total_net' => $suppliers->sum('total_net')
        ];

        $settings = (array) DB::table('settings')->first();
        $lang = $this->getLanguageArray();
        
        return view('purchases::reports.suppliers', compact('suppliers', 'totals', 'from_date', 'to_date', 'settings', 'lang'));
    }

    private function getLanguageArray()
    {
        return cache()->remember('language_ar', 3600, function () {
            $cached = cache()->get('laravel-cache-language_ar');
            return $cached ?: [];
        });
    }
}