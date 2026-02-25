<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = DB::table('employees')
            ->where('isdeleted', '!=', 1)
            ->orderBy('id', 'desc')
            ->get();

        // Get related data for each employee
        foreach ($employees as $employee) {
            // Get job
            $job = DB::table('jops')->where('id', $employee->jop)->first();
            $employee->job_name = $job->name ?? 'null';

            // Get KBI sum
            $kbiSum = DB::table('emp_kbis')
                ->where('emp_id', $employee->id)
                ->sum('kbi_sum');
            $employee->kbi_sum = $kbiSum ?? 0;

            // Get department
            $department = DB::table('departments')->where('id', $employee->department)->first();
            $employee->department_name = $department->name ?? '';

            // Get shift
            $shift = DB::table('shifts')->where('id', $employee->shift)->first();
            $employee->shift_name = $shift->name ?? '';
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::employees.index', compact('employees', 'settings', 'lang', ));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        \Log::info('Employee create page accessed');
        // Get dropdown data
        $jobs = DB::table('jops')->get();
        $departments = DB::table('departments')->get();
        $shifts = DB::table('shifts')->get();
        $jopTypes = DB::table('joptybes')->get();
        $jopLevels = DB::table('joplevels')->get();
        $towns = DB::table('towns')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::employees.create', compact('jobs', 'departments', 'shifts', 'jopTypes', 'jopLevels', 'towns', 'settings', 'lang', ));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        \Log::info('Employee store request data:', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:6|max:50',
            'number' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'dateofbirth' => 'nullable|date',
            'gender' => 'required|in:0,1',
            'jop' => 'required|exists:jops,id',
            'department' => 'nullable|exists:departments,id',
            'shift' => 'nullable|exists:shifts,id',
            'salary' => 'nullable|numeric',
            'basmaid' => 'nullable|numeric',
            'hour_extra' => 'nullable|numeric',
            'day_extra' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            \Log::warning('Employee store validation failed:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check for duplicate name
        $existingEmployee = DB::table('employees')->where('name', $request->name)->first();
        if ($existingEmployee) {
            return redirect()->back()
                ->with('error', 'يوجد إدخال بهذا الاسم مسجل مسبقاً')
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $imageName = null;
            if ($request->hasFile('imgs')) {
                $file = $request->file('imgs');
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'png', 'gif', 'jpeg'];
                
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    return redirect()->back()
                        ->with('error', 'الملف المحمل ليس صورة أو امتداد غير مسموح به')
                        ->withInput();
                }

                if ($file->getSize() > 20000000) {
                    return redirect()->back()
                        ->with('error', 'بعض الملفات أكبر من اللازم 20 ميجا بايت')
                        ->withInput();
                }

                $imageName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . rand(1, 1000000) . '.' . $extension;
                
                // Ensure assets directory exists
                if (!file_exists(public_path('assets'))) {
                    mkdir(public_path('assets'), 0777, true);
                }
                
                $file->move(public_path('assets'), $imageName);
            }

            // Insert employee
            $employeeId = DB::table('employees')->insertGetId([
                'name' => $request->name,
                'info' => $request->info ?? null,
                'imgs' => $imageName,
                'email' => $request->email ?? null,
                'number' => $request->number ?? null,
                'dateofbirth' => $request->dateofbirth ?? null,
                'gender' => $request->gender,
                'address' => $request->address ?? null,
                'address2' => $request->address2 ?? null,
                'town' => $request->town ?? null,
                'jop' => $request->jop,
                'department' => $request->department ?? null,
                'joptybe' => $request->joptybe ?? null,
                'joplevel' => $request->joplevel ?? null,
                'dateofhire' => $request->dateofhire ?? null,
                'dateofend' => $request->dateofend ?? null,
                'shift' => $request->shift ?? null,
                'salary' => $request->salary ?? null,
                'basma_id' => $request->basmaid ?? null,
                'password' => $request->password ?? null,
                'basma_name' => $request->basmaname ?? null,
                'ent_tybe' => $request->ent_tybe ?? null,
                'hour_extra' => $request->hour_extra ?? null,
                'day_extra' => $request->day_extra ?? null,
                'active' => $request->has('active') ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create account for employee
            $lastAccount = DB::table('acc_head')
                ->where('code', 'like', '213%')
                ->where('is_basic', 0)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastAccount) {
                $acccode = explode('213', $lastAccount->code);
                $lstacc = $acccode[1] ?? '000';
                $lstaccInt = (int)$lstacc;
                $lstaccInt++;
                $lstaccNew = sprintf("%03d", $lstaccInt);
                $lastId = '213' . $lstaccNew;
            } else {
                $lastId = '213001';
            }

            DB::table('acc_head')->insert([
                'code' => $lastId,
                'aname' => $request->name,
                'is_basic' => 0,
                'rentable' => 0,
                'is_fund' => 0,
                'parent_id' => 35, // Financial account parent
                'is_stock' => 0,
                'secret' => 0,
                'kind' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Log process
            DB::table('process')->insert([
                'type' => 'add employee',
                'created_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('employees.index')
                ->with('success', 'تم إضافة الموظف بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving employee: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('employees.index')
                ->with('error', 'معرف الموظف مطلوب');
        }

        $employee = DB::table('employees')->where('id', $id)->first();
        
        if (!$employee) {
            return redirect()->route('employees.index')
                ->with('error', 'الموظف غير موجود');
        }

        // Get dropdown data
        $jobs = DB::table('jops')->get();
        $departments = DB::table('departments')->get();
        $shifts = DB::table('shifts')->get();
        $jopTypes = DB::table('joptybes')->get();
        $jopLevels = DB::table('joplevels')->get();
        $towns = DB::table('towns')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::employees.edit', compact('employee', 'jobs', 'departments', 'shifts', 'jopTypes', 'jopLevels', 'towns', 'settings', 'lang', ));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('employees.index')
                ->with('error', 'معرف الموظف مطلوب');
        }

        $employee = DB::table('employees')->where('id', $id)->first();
        if (!$employee) {
            return redirect()->route('employees.index')
                ->with('error', 'الموظف غير موجود');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:6|max:50',
            'number' => 'nullable|string',
            'email' => 'nullable|email',
            'dateofbirth' => 'nullable|date',
            'gender' => 'required|in:0,1',
            'jop' => 'required|exists:jops,id',
            'department' => 'nullable|exists:departments,id',
            'shift' => 'nullable|exists:shifts,id',
            'salary' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'number' => $request->number ?? null,
            'email' => $request->email ?? null,
            'dateofbirth' => $request->dateofbirth ?? null,
            'gender' => $request->gender,
            'info' => $request->info ?? null,
            'active' => $request->has('active') ? 1 : 0,
            'address' => $request->address ?? null,
            'address2' => $request->address2 ?? null,
            'town' => $request->town ?? null,
            'jop' => $request->jop,
            'department' => $request->department ?? null,
            'joplevel' => $request->joplevel ?? null,
            'joptybe' => $request->joptybe ?? null,
            'dateofhire' => $request->dateofhire ?? null,
            'dateofend' => $request->dateofend ?? null,
            'salary' => $request->salary ?? null,
            'shift' => $request->shift ?? null,
            'basma_id' => $request->basma_id ?? null,
            'basma_name' => $request->basma_name ?? null,
            'password' => $request->password ?? null,
            'hour_extra' => $request->hour_extra ?? null,
            'day_extra' => $request->day_extra ?? null,
            'ent_tybe' => $request->ent_tybe ?? null,
            'updated_at' => now(),
        ];

        // Handle image upload
        if ($request->hasFile('imgs')) {
            $file = $request->file('imgs');
            $extension = $file->getClientOriginalExtension();
            $allowedExtensions = ['jpg', 'png', 'gif', 'jpeg'];
            
            if (in_array(strtolower($extension), $allowedExtensions) && $file->getSize() <= 20000000) {
                $imageName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . rand(1, 1000000) . '.' . $extension;
                $file->move(public_path('assets'), $imageName);
                $updateData['imgs'] = $imageName;
            }
        }

        DB::table('employees')
            ->where('id', $id)
            ->update($updateData);

        return redirect()->route('employees.index')
            ->with('success', 'تم تحديث الموظف بنجاح');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('employees.index')
                ->with('error', 'معرف الموظف مطلوب');
        }

        // Soft delete
        DB::table('employees')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('employees.index')
            ->with('success', 'تم حذف الموظف بنجاح');
    }
}