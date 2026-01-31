<?php

namespace Modules\Contracts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    // Training Contracts (type = 1)
    public function trainingIndex()
    {
        $contracts = DB::table('hiringcontracts')
            ->where('type', 1)
            ->whereNull('isdeleted')
            ->orderBy('id', 'desc')
            ->get();

        // Get employee and job names
        foreach ($contracts as $contract) {
            $employee = DB::table('employees')->where('id', $contract->employee)->first();
            $contract->employee_name = $employee->name ?? '';
            
            $job = DB::table('jops')->where('id', $contract->jop)->first();
            $contract->job_name = $job->name ?? '';
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('contracts::training.index', compact('contracts', 'settings', 'lang', ));
    }

    // Hiring Contracts (type = 0)
    public function hiringIndex()
    {
        $contracts = DB::table('hiringcontracts')
            ->where('type', 0)
            ->whereNull('isdeleted')
            ->orderBy('id', 'desc')
            ->get();

        // Get employee and job names
        foreach ($contracts as $contract) {
            $employee = DB::table('employees')->where('id', $contract->employee)->first();
            $contract->employee_name = $employee->name ?? '';
            
            $job = DB::table('jops')->where('id', $contract->jop)->first();
            $contract->job_name = $job->name ?? '';
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('contracts::hiring.index', compact('contracts', 'settings', 'lang', ));
    }

    // External Contracts (type = 2)
    public function externalIndex()
    {
        $contracts = DB::table('hiringcontracts')
            ->where('type', 2)
            ->whereNull('isdeleted')
            ->orderBy('id', 'desc')
            ->get();

        // Get employee and job names
        foreach ($contracts as $contract) {
            $employee = DB::table('employees')->where('id', $contract->employee)->first();
            $contract->employee_name = $employee->name ?? '';
            
            $job = DB::table('jops')->where('id', $contract->jop)->first();
            $contract->job_name = $job->name ?? '';
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('contracts::external.index', compact('contracts', 'settings', 'lang', ));
    }

    public function createTraining()
    {
        $employees = DB::table('employees')->where('isdeleted', '!=', 1)->orderBy('name')->get();
        $jobs = DB::table('jops')->where('isdeleted', '!=', 1)->orderBy('name')->get();
        $allowances = DB::table('allowances')->orderBy('name')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('contracts::training.create', compact('employees', 'jobs', 'allowances', 'settings', 'lang', ));
    }

    public function createHiring()
    {
        $employees = DB::table('employees')->where('isdeleted', '!=', 1)->orderBy('name')->get();
        $jobs = DB::table('jops')->where('isdeleted', '!=', 1)->orderBy('name')->get();
        $allowances = DB::table('allowances')->orderBy('name')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('contracts::hiring.create', compact('employees', 'jobs', 'allowances', 'settings', 'lang', ));
    }

    public function createExternal()
    {
        $employees = DB::table('employees')->where('isdeleted', '!=', 1)->orderBy('name')->get();
        $jobs = DB::table('jops')->where('isdeleted', '!=', 1)->orderBy('name')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('contracts::external.create', compact('employees', 'jobs', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        // Determine type from route name
        $routeName = $request->route()->getName();
        $type = 0; // default hiring
        if (strpos($routeName, 'training') !== false) {
            $type = 1;
        } elseif (strpos($routeName, 'external') !== false) {
            $type = 2;
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'employee' => 'required|exists:employees,id',
            'jop' => 'required|exists:jops,id',
            'jopdescription' => 'required|string',
            'startcontract' => 'required|date',
            'endcontract' => 'required|date|after:startcontract',
            'workhours' => 'required|numeric|min:0',
            'workdaysoff' => 'required|numeric|min:0',
            'info' => 'required|string',
            'joprule1' => 'required|string',
            'salary' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = session('userid');

        $contractId = DB::table('hiringcontracts')->insertGetId([
            'name' => $request->name,
            'employee' => $request->employee,
            'jop' => $request->jop,
            'jopdescription' => $request->jopdescription,
            'salary' => $request->salary,
            'salaryraise' => $request->salaryraise ?? 0,
            'startcontract' => $request->startcontract,
            'endcontract' => $request->endcontract,
            'workhours' => $request->workhours,
            'inorderhours' => $request->inorderhours ?? 0,
            'workdaysoff' => $request->workdaysoff,
            'info' => $request->info,
            'user' => $userId,
            'joprule1' => $request->joprule1,
            'joprule2' => $request->joprule2 ?? null,
            'joprule3' => $request->joprule3 ?? null,
            'joprule4' => $request->joprule4 ?? null,
            'type' => $type,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Handle allowances if provided
        if ($request->has('allow') && is_array($request->allow)) {
            foreach ($request->allow as $index => $allowId) {
                if (isset($request->value[$index])) {
                    DB::table('emp_allowences')->insert([
                        'empid' => $request->employee,
                        'allowid' => $allowId,
                        'value' => $request->value[$index],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        DB::table('process')->insert([
            'type' => 'add hiring contract',
            'created_at' => now(),
        ]);

        $routeName = $type == 1 ? 'contracts.training.index' : ($type == 2 ? 'contracts.external.index' : 'contracts.hiring.index');
        
        return redirect()->route($routeName)
            ->with('success', 'تم إضافة العقد بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف العقد مطلوب');
        }

        $contract = DB::table('hiringcontracts')->where('id', $id)->first();
        if (!$contract) {
            return redirect()->back()->with('error', 'العقد غير موجود');
        }

        $employees = DB::table('employees')->where('isdeleted', '!=', 1)->orderBy('name')->get();
        $jobs = DB::table('jops')->where('isdeleted', '!=', 1)->orderBy('name')->get();
        $allowances = DB::table('allowances')->orderBy('name')->get();

        // Get contract allowances
        $contractAllowances = DB::table('emp_allowences')
            ->where('empid', $contract->employee)
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        $viewName = $contract->type == 1 ? 'contracts::training.edit' : ($contract->type == 2 ? 'contracts::external.edit' : 'contracts::hiring.edit');

        return view($viewName, compact('contract', 'employees', 'jobs', 'allowances', 'contractAllowances', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف العقد مطلوب');
        }

        $contract = DB::table('hiringcontracts')->where('id', $id)->first();
        if (!$contract) {
            return redirect()->back()->with('error', 'العقد غير موجود');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'employee' => 'required|exists:employees,id',
            'jop' => 'required|exists:jops,id',
            'jopdescription' => 'required|string',
            'startcontract' => 'required|date',
            'endcontract' => 'required|date|after:startcontract',
            'workhours' => 'required|numeric|min:0',
            'workdaysoff' => 'required|numeric|min:0',
            'info' => 'required|string',
            'joprule1' => 'required|string',
            'salary' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('hiringcontracts')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'employee' => $request->employee,
                'jop' => $request->jop,
                'jopdescription' => $request->jopdescription,
                'salary' => $request->salary,
                'salaryraise' => $request->salaryraise ?? 0,
                'startcontract' => $request->startcontract,
                'endcontract' => $request->endcontract,
                'workhours' => $request->workhours,
                'inorderhours' => $request->inorderhours ?? 0,
                'workdaysoff' => $request->workdaysoff,
                'info' => $request->info,
                'joprule1' => $request->joprule1,
                'joprule2' => $request->joprule2 ?? null,
                'joprule3' => $request->joprule3 ?? null,
                'joprule4' => $request->joprule4 ?? null,
                'updated_at' => now(),
            ]);

        // Update allowances if provided
        if ($request->has('allow') && is_array($request->allow)) {
            // Delete old allowances for this employee
            DB::table('emp_allowences')->where('empid', $request->employee)->delete();
            
            // Insert new allowances
            foreach ($request->allow as $index => $allowId) {
                if (isset($request->value[$index])) {
                    DB::table('emp_allowences')->insert([
                        'empid' => $request->employee,
                        'allowid' => $allowId,
                        'value' => $request->value[$index],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $routeName = $contract->type == 1 ? 'contracts.training.index' : ($contract->type == 2 ? 'contracts.external.index' : 'contracts.hiring.index');
        
        return redirect()->route($routeName)
            ->with('success', 'تم تحديث العقد بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف العقد مطلوب');
        }

        $contract = DB::table('hiringcontracts')->where('id', $id)->first();
        if (!$contract) {
            return redirect()->back()->with('error', 'العقد غير موجود');
        }

        // Soft delete
        DB::table('hiringcontracts')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        $routeName = $contract->type == 1 ? 'contracts.training.index' : ($contract->type == 2 ? 'contracts.external.index' : 'contracts.hiring.index');
        
        return redirect()->route($routeName)
            ->with('success', 'تم حذف العقد بنجاح');
    }
}