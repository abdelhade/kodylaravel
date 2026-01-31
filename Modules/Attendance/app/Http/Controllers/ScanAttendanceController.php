<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ScanAttendanceController extends Controller
{
    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::scan-attendance.index', compact('settings', 'lang', ));
    }

    public function scan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee' => 'required|string',
            'fptybe' => 'required|in:1,2',
            'fpdate' => 'required|date',
            'fptime' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'البيانات غير صحيحة'
            ], 400);
        }

        try {
            // Get employee by id (the barcode scanner sends employee ID)
            $employee = DB::table('employees')
                ->where('id', $request->employee)
                ->first();

            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يوجد موظف بهذا الرقم'
                ], 404);
            }

            // Check if record already exists for this employee, date, and type
            $existing = DB::table('attandance')
                ->where('employee', $employee->id)
                ->where('fpdate', $request->fpdate)
                ->where('fptybe', $request->fptybe)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'تم تسجيل الحضور مسبقاً لهذا الموظف في هذا التاريخ'
                ], 409);
            }

            // Insert attendance record
            DB::table('attandance')->insert([
                'employee' => $employee->id,
                'fptybe' => $request->fptybe,
                'fpdate' => $request->fpdate,
                'time' => $request->fptime,
                'user' => session('userid', 1),
                'fromwhere' => 2, // From barcode scanner
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل الحضور بنجاح للموظف: ' . $employee->name
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
}