<?php

namespace Modules\POS\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClosedSessionController extends Controller
{
    public function index()
    {
        $closedSessions = DB::table('closed_orders')
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pos::closed-sessions.index', compact('closedSessions', 'settings', 'lang', ));
    }

    public function close(Request $request)
    {
        $userId = session('userid');
        if (!$userId) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $shiftDate = date('Y-m-d');
        $shiftTime = date('H:i:s');

        try {
            // Calculate sales for current user today
            $salesData = DB::table('ot_head')
                ->whereDate('pro_date', $shiftDate)
                ->where('pro_tybe', 9)
                ->where('isdeleted', 0)
                ->where('fat_net', '>', 0)
                ->where('user', $userId)
                ->selectRaw('COUNT(*) as total_orders, COALESCE(SUM(fat_net), 0) as total_sales')
                ->first();

            $totalOrders = intval($salesData->total_orders ?? 0);
            $totalSales = floatval($salesData->total_sales ?? 0);

            // Get user name
            $userAccount = DB::table('acc_head')->where('id', $userId)->first();
            $username = $userAccount->aname ?? 'Unknown';

            // Insert closed shift record
            $shiftNumber = date('Ymd') . '_' . $userId;
            
            DB::table('closed_orders')->insert([
                'shift' => $shiftNumber,
                'date' => $shiftDate,
                'user' => $username,
                'endtime' => $shiftTime,
                'total_sales' => $totalSales,
                'expenses' => 0,
                'exp_notes' => 'إغلاق تلقائي',
                'cash' => $totalSales,
                'fund_after' => $totalSales,
                'info' => 'إغلاق شيفت تلقائي - عدد الطلبات: ' . $totalOrders,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($totalOrders > 0) {
                $message = "تم إغلاق الشيفت بنجاح - إجمالي مبيعاتك: " . number_format($totalSales, 2) . " ج.م (" . $totalOrders . " طلب)";
            } else {
                $message = "تم إغلاق الشيفت - لا توجد مبيعات لك اليوم";
            }

            return redirect()->route('pos.sessions')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إغلاق الشيفت: ' . $e->getMessage());
        }
    }
}