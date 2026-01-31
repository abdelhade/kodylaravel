<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeKBIController extends Controller
{
    public function index()
    {
        // Get employees with their KBIs
        $employees = DB::table('employees as e')
            ->leftJoin('emp_kbis as ek', 'e.id', '=', 'ek.emp_id')
            ->leftJoin('kbis as k', 'ek.kbi_id', '=', 'k.id')
            ->where('e.isdeleted', '!=', 1)
            ->select('e.id as emp_id', 'e.name as emp_name', DB::raw('GROUP_CONCAT(k.kname) as knames'))
            ->groupBy('e.id', 'e.name')
            ->get();

        // Process knames for each employee
        foreach ($employees as $employee) {
            $employee->knames_array = $employee->knames ? explode(',', $employee->knames) : [];
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::emp-kbis.index', compact('employees', 'settings', 'lang', ));
    }

    public function create(Request $request)
    {
        $employeeName = $request->get('c');
        $employeeId = $request->get('i');
        $query = $request->get('q');

        // Get employees without KBIs (for new assignments)
        $employees = DB::table('employees as e')
            ->leftJoin('emp_kbis as k', 'e.id', '=', 'k.emp_id')
            ->where('e.isdeleted', '!=', 1)
            ->whereNull('k.emp_id')
            ->select('e.*')
            ->orderBy('e.id', 'desc')
            ->get();

        // Also include employees with KBIs if copying
        if ($employeeId) {
            $allEmployees = DB::table('employees')
                ->where('isdeleted', '!=', 1)
                ->orderBy('name')
                ->get();
            $employees = $allEmployees;
        }

        $kbis = DB::table('kbis')
            ->where('isdeleted', 0)
            ->orderBy('kname')
            ->get();

        // If copying from another employee
        $selectedKbis = [];
        if ($employeeId && $query == 'f898sd897fg98') {
            $selectedKbis = DB::table('emp_kbis')
                ->where('emp_id', $employeeId)
                ->pluck('kbi_id')
                ->toArray();
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::emp-kbis.create', compact('employees', 'kbis', 'employeeName', 'employeeId', 'selectedKbis', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emp_id' => 'required|exists:employees,id',
            'kbi_id' => 'required|array',
            'kbi_id.*' => 'exists:kbis,id',
            'kbi_weight' => 'required|array',
            'kbi_weight.*' => 'numeric|min:0',
            'total_kbi' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validate total KBI equals 100
        $totalKBI = floatval($request->total_kbi);
        if (abs($totalKBI - 100) > 0.01) {
            return redirect()->back()
                ->with('error', 'المجموع الكلي يجب أن يساوي 100')
                ->withInput();
        }

        $employeeId = $request->emp_id;

        // Delete existing KBIs for this employee
        DB::table('emp_kbis')->where('emp_id', $employeeId)->delete();

        // Insert new KBIs with weights
        foreach ($request->kbi_id as $key => $kbiId) {
            DB::table('emp_kbis')->insert([
                'emp_id' => $employeeId,
                'kbi_id' => $kbiId,
                'kbi_weight' => $request->kbi_weight[$key] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('process')->insert([
            'type' => 'add emp kbi',
            'created_at' => now(),
        ]);

        return redirect()->route('emp-kbis.index')
            ->with('success', 'تم إضافة معدلات التقييم للموظف بنجاح');
    }
}