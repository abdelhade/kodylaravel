<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManualAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $employees = DB::table('employees')->where('isdeleted', '!=', 1)->orderBy('name')->get();

        // Get filter parameters
        $employeeId = $request->post('employee', 0);
        $fromDate = $request->post('fromdate');
        $toDate = $request->post('todate');

        // Build query
        if ($fromDate && $toDate) {
            if ($employeeId == 0) {
                $attendances = DB::table('attandance')
                    ->whereBetween('fpdate', [$fromDate, $toDate])
                    ->where('isdeleted', '!=', 1)
                    ->orderBy('fpdate', 'asc')
                    ->get();
            } else {
                $attendances = DB::table('attandance')
                    ->where('employee', $employeeId)
                    ->whereBetween('fpdate', [$fromDate, $toDate])
                    ->where('isdeleted', '!=', 1)
                    ->orderBy('fpdate', 'asc')
                    ->get();
            }
        } else {
            // Default: today's records (last 60)
            $today = date('Y-m-d');
            $attendances = DB::table('attandance')
                ->whereBetween('fpdate', [$today, $today])
                ->where('isdeleted', '!=', 1)
                ->orderBy('id', 'desc')
                ->limit(60)
                ->get();
        }

        // Get employee and fingerprint type names
        foreach ($attendances as $attendance) {
            $employee = DB::table('employees')->where('id', $attendance->employee)->first();
            $attendance->employee_name = $employee->name ?? '';
            
            $fpType = DB::table('fptybes')->where('id', $attendance->fptybe)->first();
            $attendance->fp_type_name = $fpType->name ?? '';
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::manual-attendance.index', compact('employees', 'attendances', 'employeeId', 'fromDate', 'toDate', 'settings', 'lang', ));
    }

    public function create()
    {

        $employees = DB::table('employees')->where('isdeleted', '!=', 1)->orderBy('name')->get();
        $fpTypes = DB::table('fptybes')->orderBy('id')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::manual-attendance.create', compact('employees', 'fpTypes', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee' => 'required|exists:employees,id',
            'fptybe' => 'required|exists:fptybes,id',
            'fpdate' => 'nullable|date',
            'fptime' => 'nullable|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = session('userid');
        $fpDate = $request->fpdate ?? date('Y-m-d');
        $fpTime = $request->fptime ?? date('H:i');

        DB::table('attandance')->insert([
            'employee' => $request->employee,
            'fptybe' => $request->fptybe,
            'fpdate' => $fpDate,
            'time' => $fpTime,
            'user' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add manual fb',
            'created_at' => now(),
        ]);

        return redirect()->route('manual-attendance.index')
            ->with('success', 'تم إضافة البصمة بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف البصمة مطلوب');
        }

        $attendance = DB::table('attandance')->where('id', $id)->first();
        if (!$attendance) {
            return redirect()->back()->with('error', 'البصمة غير موجودة');
        }

        $employees = DB::table('employees')->where('isdeleted', '!=', 1)->orderBy('name')->get();
        $fpTypes = DB::table('fptybes')->orderBy('id')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::manual-attendance.edit', compact('attendance', 'employees', 'fpTypes', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف البصمة مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'employee' => 'required|exists:employees,id',
            'fptybe' => 'required|exists:fptybes,id',
            'fpdate' => 'required|date',
            'fptime' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('attandance')
            ->where('id', $id)
            ->update([
                'employee' => $request->employee,
                'fptybe' => $request->fptybe,
                'fpdate' => $request->fpdate,
                'time' => $request->fptime,
                'updated_at' => now(),
            ]);

        return redirect()->route('manual-attendance.index')
            ->with('success', 'تم تحديث البصمة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف البصمة مطلوب');
        }

        // Soft delete
        DB::table('attandance')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('manual-attendance.index')
            ->with('success', 'تم حذف البصمة بنجاح');
    }
}