<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReportsController extends Controller
{
    /**
     * Display sales reports index page.
     */
    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('sales::reports.index', compact('settings', 'lang', ));
    }

    /**
     * Display sales by day report.
     */
    public function byDay(Request $request)
    {
        $from = $request->get('from', date('Y-m-d'));
        $to = $request->get('to', date('Y-m-d'));

        if ($request->isMethod('post')) {
            $from = $request->input('from', date('Y-m-d'));
            $to = $request->input('to', date('Y-m-d'));
        }

        $data = DB::table('ot_head')
            ->select(DB::raw('pro_date, SUM(pro_value) as total_sales'))
            ->whereIn('pro_tybe', [9, 3])
            ->whereBetween('pro_date', [$from, $to])
            ->groupBy('pro_date')
            ->orderBy('pro_date', 'asc')
            ->get();

        $grand_total = $data->sum('total_sales');
        $count_days = $data->count();

        $max_day = $min_day = $avg_day = null;
        if ($count_days > 0) {
            $sorted = $data->sortByDesc('total_sales')->values();
            $max_day = $sorted->first();
            $min_day = $sorted->last();
            $avg_day = $grand_total / $count_days;
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('sales::reports.by-day', compact('data', 'from', 'to', 'grand_total', 'count_days', 'max_day', 'min_day', 'avg_day', 'settings', 'lang', ));
    }

    /**
     * Display sales by hour report.
     */
    public function byHour(Request $request)
    {
        $from = $request->get('from', date('Y-m-d'));
        $to = $request->get('to', date('Y-m-d'));

        if ($request->isMethod('post')) {
            $from = $request->input('from', date('Y-m-d'));
            $to = $request->input('to', date('Y-m-d'));
        }

        $hoursData = DB::table('ot_head')
            ->select(DB::raw('HOUR(crtime) as sales_hour, SUM(pro_value) as total_sales'))
            ->whereIn('pro_tybe', [9, 3])
            ->whereBetween(DB::raw('DATE(crtime)'), [$from, $to])
            ->groupBy('sales_hour')
            ->orderBy('sales_hour', 'asc')
            ->get();

        $hours = array_fill(0, 24, 0);
        foreach ($hoursData as $row) {
            $hours[(int)$row->sales_hour] = $row->total_sales;
        }

        $grand_total = array_sum($hours);
        $avg = $grand_total / 24;
        $filtered = array_filter($hours, fn($v) => $v > 0);
        $max_val = count($filtered) > 0 ? max($filtered) : 0;
        $min_val = count($filtered) > 0 ? min($filtered) : 0;
        $max_hour = array_search($max_val, $hours);
        $min_hour = array_search($min_val, $hours);

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('sales::reports.by-hour', compact('hours', 'from', 'to', 'grand_total', 'avg', 'max_hour', 'min_hour', 'max_val', 'min_val', 'settings', 'lang', ));
    }

    /**
     * Display sales by week report.
     */
    public function byWeek(Request $request)
    {
        $from = $request->get('from', date('Y-m-01'));
        $to = $request->get('to', date('Y-m-t'));

        if ($request->isMethod('post')) {
            $from = $request->input('from', date('Y-m-01'));
            $to = $request->input('to', date('Y-m-t'));
        }

        $weeks = DB::table('ot_head')
            ->select(DB::raw('YEARWEEK(pro_date, 1) as sales_week, MIN(pro_date) as week_start, MAX(pro_date) as week_end, SUM(pro_value) as total_sales'))
            ->whereIn('pro_tybe', [9, 3])
            ->whereBetween('pro_date', [$from, $to])
            ->groupBy('sales_week')
            ->orderBy('sales_week', 'asc')
            ->get();

        $grand_total = $weeks->sum('total_sales');
        $count_weeks = $weeks->count();

        $max_week = $min_week = $avg_week = null;
        if ($count_weeks > 0) {
            $sorted = $weeks->sortByDesc('total_sales')->values();
            $max_week = $sorted->first();
            $min_week = $sorted->last();
            $avg_week = $grand_total / $count_weeks;
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('sales::reports.by-week', compact('weeks', 'from', 'to', 'grand_total', 'count_weeks', 'max_week', 'min_week', 'avg_week', 'settings', 'lang', ));
    }

    /**
     * Display sales by month report.
     */
    public function byMonth(Request $request)
    {
        $from = $request->get('from', date('Y-m-01'));
        $to = $request->get('to', date('Y-m-t'));

        if ($request->isMethod('post')) {
            $from = $request->input('from', date('Y-m-01'));
            $to = $request->input('to', date('Y-m-t'));
        }

        $months = DB::table('ot_head')
            ->select(DB::raw("DATE_FORMAT(pro_date, '%Y-%m') as sales_month, SUM(pro_value) as total_sales"))
            ->whereIn('pro_tybe', [9, 3])
            ->whereBetween('pro_date', [$from, $to])
            ->groupBy('sales_month')
            ->orderBy('sales_month', 'asc')
            ->get();

        $grand_total = $months->sum('total_sales');

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('sales::reports.by-month', compact('months', 'from', 'to', 'grand_total', 'settings', 'lang', ));
    }

    /**
     * Display operations summary report.
     */
    public function operationsSummary(Request $request)
    {
        $q = $request->get('q', 'all');
        $strtdate = $request->input('strtdate', date('Y-m-d'));
        $enddate = $request->input('enddate', date('Y-m-d'));

        // Determine report type
        $report_name = "التقرير الشامل";
        $query = DB::table('ot_head')->where('isdeleted', '!=', 1);

        switch ($q) {
            case "sale":
                $report_name = "مشتريات";
                $query->where('pro_tybe', 4);
                break;
            case "buy":
                $report_name = "مبيعات";
                $query->whereIn('pro_tybe', [2, 3, 9]);
                break;
            default:
                // All operations
                break;
        }

        // Apply date filter
        if ($strtdate && $enddate) {
            $query->whereBetween('pro_date', [$strtdate, $enddate]);
        } else {
            $query->where('pro_date', date('Y-m-d'));
        }

        $operations = $query->orderBy('id', 'desc')->get();

        // Get related data
        $proTypes = DB::table('pro_tybes')->pluck('pname', 'id')->toArray();
        $accounts = DB::table('acc_head')->pluck('aname', 'id')->toArray();
        $users = DB::table('users')->pluck('uname', 'id')->toArray();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('sales::reports.operations-summary', compact(
            'operations', 
            'q', 
            'report_name', 
            'strtdate', 
            'enddate', 
            'proTypes', 
            'accounts', 
            'users', 
            'settings', 
            'lang'
        ));
    }

    /**
     * Display items summary report.
     */
    public function itemsSummary(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        // Get all items
        $items = DB::table('myitems')->where('isdeleted', 0)->get();

        $itemsData = [];
        foreach ($items as $item) {
            $query = DB::table('fat_details')
                ->where('isdeleted', 0)
                ->where('item_id', $item->id)
                ->whereIn('fat_tybe', [9, 3]);

            // Apply date filter
            if ($from && $to) {
                $query->whereBetween('crtime', [$from . ' 00:00:00', $to . ' 23:59:59']);
            } elseif ($from) {
                $query->where('crtime', '>=', $from . ' 00:00:00');
            } elseif ($to) {
                $query->where('crtime', '<=', $to . ' 23:59:59');
            }

            $sumqty = $query->sum('qty_out');
            $sumvalue = $query->sum('det_value');

            $itemsData[] = [
                'id' => $item->id,
                'code' => $item->code,
                'iname' => $item->iname,
                'qty' => $sumqty ?? 0,
                'value' => $sumvalue ?? 0,
                'price1' => $item->price1,
                'cost_price' => $item->cost_price,
            ];
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('sales::reports.items-summary', compact('itemsData', 'from', 'to', 'settings', 'lang'));
    }
}