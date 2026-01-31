<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    public function index()
    {

        $salaryDocs = DB::table('attdocs')
            ->where('isdeleted', '!=', 1)
            ->orderBy('id', 'desc')
            ->get();

        // Get employee info and calculate details for each doc
        foreach ($salaryDocs as $doc) {
            $employee = DB::table('employees')->where('id', $doc->empid)->first();
            $doc->employee_name = $employee->name ?? '';
            $doc->employee_salary = $employee->salary ?? 0;

            // Calculate extra hours
            $startDate = $doc->fromdate;
            $endDate = $doc->todate;
            $extraHours = DB::table('attlog')
                ->where('employee', $doc->empid)
                ->where('curhours', '>', DB::raw('defhours'))
                ->whereBetween('day', [$startDate, $endDate])
                ->selectRaw('SUM(curhours - defhours) as diffrence')
                ->first();
            
            $totalExtraHours = DB::table('attlog')
                ->where('employee', $doc->empid)
                ->where('statue', '!=', 0)
                ->whereBetween('day', [$startDate, $endDate])
                ->selectRaw('SUM(curhours) - SUM(defhours) as diffrence')
                ->first();

            $doc->extra_hours = round($extraHours->diffrence ?? 0, 2);
            $doc->total_extra_hours = round($totalExtraHours->diffrence ?? 0, 2);

            // Get production value
            $production = DB::table('productions')
                ->where('emp_name', $doc->employee_name)
                ->whereBetween('date', [$startDate, $endDate])
                ->selectRaw('SUM(value) as prod_val')
                ->first();
            $doc->production_value = $production->prod_val ?? 0;
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::salary.index', compact('salaryDocs', 'settings', 'lang'));
    }

    public function create()
    {

        $employees = DB::table('employees')
            ->where(function($query) {
                $query->where('isdeleted', '!=', 1)
                      ->orWhereNull('isdeleted');
            })
            ->orderBy('name')
            ->get();

        $departments = DB::table('departments')
            ->where(function($query) {
                $query->where('isdeleted', '!=', 1)
                      ->orWhereNull('isdeleted');
            })
            ->orderBy('name')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::salary.create', compact('employees', 'departments', 'settings', 'lang'));
    }

    public function destroy(Request $request)
    {
        $doc = $request->get('doc');
        if (!$doc) {
            return redirect()->back()->with('error', 'معرف الدفتر مطلوب');
        }

        // Delete related attlog records
        DB::table('attlog')->where('attdoc', $doc)->delete();
        
        // Delete attdoc
        DB::table('attdocs')->where('id', $doc)->delete();

        return redirect()->route('salary.index')
            ->with('success', 'تم حذف دفتر الحضور بنجاح');
    }
}
