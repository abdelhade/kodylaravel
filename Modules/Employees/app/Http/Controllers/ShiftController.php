<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = DB::table('shifts')
            ->orderBy('id', 'desc')
            ->get();

        // Process working days for each shift
        foreach ($shifts as $shift) {
            $workingDays = explode(',', $shift->workingdays ?? '');
            $shift->holidays = $this->getHolidays($workingDays);
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::shifts.index', compact('shifts', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::shifts.create', compact('settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'shiftstart' => 'required',
            'shiftend' => 'required',
            'instart' => 'required',
            'inend' => 'required',
            'outstart' => 'required',
            'outend' => 'required',
            'latelimit' => 'nullable|numeric',
            'earlylimit' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Calculate hours
        $startTime = Carbon::parse($request->shiftstart);
        $endTime = Carbon::parse($request->shiftend);
        $hours = $endTime->diffInHours($startTime);

        // Process working days
        $days = [];
        if ($request->has('sat')) $days[] = '6';
        if ($request->has('sun')) $days[] = '7';
        if ($request->has('mon')) $days[] = '1';
        if ($request->has('tus')) $days[] = '2';
        if ($request->has('wed')) $days[] = '3';
        if ($request->has('thur')) $days[] = '4';
        if ($request->has('fri')) $days[] = '5';
        $workingdays = implode(',', $days);

        DB::table('shifts')->insert([
            'name' => $request->name,
            'shiftstart' => $request->shiftstart,
            'shiftend' => $request->shiftend,
            'hours' => $hours,
            'instart' => $request->instart,
            'inend' => $request->inend,
            'outstart' => $request->outstart,
            'outend' => $request->outend,
            'latelimit' => $request->latelimit ?? 0,
            'earlylimit' => $request->earlylimit ?? 0,
            'workingdays' => $workingdays,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add shift',
            'created_at' => now(),
        ]);

        return redirect()->route('shifts.index')
            ->with('success', 'تم إضافة الوردية بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('shifts.index')
                ->with('error', 'معرف الوردية مطلوب');
        }

        $shift = DB::table('shifts')->where('id', $id)->first();
        if (!$shift) {
            return redirect()->route('shifts.index')
                ->with('error', 'الوردية غير موجودة');
        }

        $workingDays = explode(',', $shift->workingdays ?? '');
        $shift->workingDaysArray = $workingDays;

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::shifts.edit', compact('shift', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('shifts.index')
                ->with('error', 'معرف الوردية مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'shiftstart' => 'required',
            'shiftend' => 'required',
            'instart' => 'required',
            'inend' => 'required',
            'outstart' => 'required',
            'outend' => 'required',
            'latelimit' => 'nullable|numeric',
            'earlylimit' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Calculate hours
        $startTime = Carbon::parse($request->shiftstart);
        $endTime = Carbon::parse($request->shiftend);
        $hours = $endTime->diffInHours($startTime);

        // Process working days
        $days = [];
        if ($request->has('sat')) $days[] = '6';
        if ($request->has('sun')) $days[] = '7';
        if ($request->has('mon')) $days[] = '1';
        if ($request->has('tus')) $days[] = '2';
        if ($request->has('wed')) $days[] = '3';
        if ($request->has('thur')) $days[] = '4';
        if ($request->has('fri')) $days[] = '5';
        $workingdays = implode(',', $days);

        DB::table('shifts')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'shiftstart' => $request->shiftstart,
                'shiftend' => $request->shiftend,
                'hours' => $hours,
                'instart' => $request->instart,
                'inend' => $request->inend,
                'outstart' => $request->outstart,
                'outend' => $request->outend,
                'latelimit' => $request->latelimit ?? 0,
                'earlylimit' => $request->earlylimit ?? 0,
                'workingdays' => $workingdays,
                'updated_at' => now(),
            ]);

        return redirect()->route('shifts.index')
            ->with('success', 'تم تحديث الوردية بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('shifts.index')
                ->with('error', 'معرف الوردية مطلوب');
        }

        // Check if shift is used by employees
        $employeesCount = DB::table('employees')
            ->where('shift', $id)
            ->count();

        if ($employeesCount > 0) {
            return redirect()->route('shifts.index')
                ->with('error', 'لا يمكن حذف الوردية لأنها مستخدمة من قبل موظفين');
        }

        DB::table('shifts')->where('id', $id)->delete();

        return redirect()->route('shifts.index')
            ->with('success', 'تم حذف الوردية بنجاح');
    }

    private function getHolidays($workingDays)
    {
        $allDays = ['6' => 'السبت', '7' => 'الأحد', '1' => 'الاثنين', '2' => 'الثلاثاء', '3' => 'الأربعاء', '4' => 'الخميس', '5' => 'الجمعة'];
        $holidays = [];
        
        foreach ($allDays as $dayNum => $dayName) {
            if (!in_array($dayNum, $workingDays)) {
                $holidays[] = $dayName;
            }
        }
        
        return implode('-', $holidays);
    }
}