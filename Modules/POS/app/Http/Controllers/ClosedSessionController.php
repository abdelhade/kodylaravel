<?php

namespace Modules\POS\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\POS\Models\ClosedSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClosedSessionController extends Controller
{
    /**
     * عرض قائمة الجلسات المغلقة
     */
    public function index()
    {
        $sessions = ClosedSession::orderBy('id', 'desc')->paginate(20);
        return view('pos::closed-sessions.index', compact('sessions'));
    }

    /**
     * إغلاق الشيفت الحالي
     */
    public function close(Request $request)
    {
        try {
            $userId = auth()->id();
            $shiftDate = now()->toDateString();
            $shiftTime = now()->toTimeString();

            // حساب مبيعات المستخدم الحالي لليوم
            $salesData = DB::table('ot_head')
                ->selectRaw('COUNT(*) as total_orders, COALESCE(SUM(fat_net), 0) as total_sales')
                ->whereDate('pro_date', $shiftDate)
                ->where('pro_tybe', 9) // POS
                ->where('isdeleted', 0)
                ->where('fat_net', '>', 0)
                ->where('user', $userId)
                ->first();

            $totalOrders = $salesData->total_orders ?? 0;
            $totalSales = $salesData->total_sales ?? 0;

            // جلب اسم المستخدم
            $user = DB::table('acc_head')->find($userId);
            $username = $user->aname ?? 'Unknown';

            // إدراج سجل إغلاق الشيفت
            $shiftNumber = now()->format('Ymd') . '_' . $userId;
            
            ClosedSession::create([
                'shift' => $shiftNumber,
                'date' => $shiftDate,
                'user' => $username,
                'endtime' => $shiftTime,
                'total_sales' => $totalSales,
                'expenses' => 0,
                'exp_notes' => 'إغلاق تلقائي',
                'cash' => $totalSales,
                'fund_after' => $totalSales,
                'info' => "إغلاق شيفت تلقائي - عدد الطلبات: $totalOrders",
                'info2' => 'auto_close',
                'tenant' => 1,
                'branch' => 1,
            ]);

            $message = $totalOrders > 0 
                ? "تم إغلاق الشيفت بنجاح - إجمالي مبيعاتك: " . number_format($totalSales, 2) . " ج.م (" . $totalOrders . " طلب)"
                : "تم إغلاق الشيفت - لا توجد مبيعات لك اليوم";

            return redirect()->route('pos.closed-sessions.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إغلاق الشيفت: ' . $e->getMessage());
        }
    }

    /**
     * عرض تفاصيل جلسة مغلقة
     */
    public function show(ClosedSession $session)
    {
        return view('pos::closed-sessions.show', compact('session'));
    }

    /**
     * تصدير الجلسات إلى Excel
     */
    public function export()
    {
        $sessions = ClosedSession::all();
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="closed_sessions_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($sessions) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            
            // رؤوس الأعمدة
            fputcsv($file, [
                'الشيفت', 'التاريخ', 'المستخدم', 'وقت الانهاء',
                'إجمالي المبيعات', 'المصاريف', 'ملاحظات المصاريف',
                'تسليم الكاش', 'نهاية الدرج', 'ملاحظات'
            ]);

            // البيانات
            foreach ($sessions as $session) {
                fputcsv($file, [
                    $session->shift,
                    $session->date,
                    $session->user,
                    $session->endtime,
                    $session->total_sales,
                    $session->expenses,
                    $session->exp_notes,
                    $session->cash,
                    $session->fund_after,
                    $session->info,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
