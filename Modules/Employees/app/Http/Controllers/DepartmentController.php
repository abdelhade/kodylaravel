<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = DB::table('departments')
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::departments.index', compact('departments', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::departments.create', compact('settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('departments')->insert([
            'name' => $request->name,
            'info' => $request->info ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add department',
            'created_at' => now(),
        ]);

        return redirect()->route('departments.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('departments.index')
                ->with('error', 'معرف القسم مطلوب');
        }

        $department = DB::table('departments')->where('id', $id)->first();
        if (!$department) {
            return redirect()->route('departments.index')
                ->with('error', 'القسم غير موجود');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::departments.edit', compact('department', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('departments.index')
                ->with('error', 'معرف القسم مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('departments')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'info' => $request->info ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('departments.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('departments.index')
                ->with('error', 'معرف القسم مطلوب');
        }

        // Check if department is used by employees
        $employeesCount = DB::table('employees')
            ->where('department', $id)
            ->count();

        if ($employeesCount > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'لا يمكن حذف القسم لأنه مستخدم من قبل موظفين');
        }

        DB::table('departments')->where('id', $id)->delete();

        return redirect()->route('departments.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }
}