<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        $jobs = DB::table('jops')
            ->where('isdeleted', '!=', 1)
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::jobs.index', compact('jobs', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::jobs.create', compact('settings', 'lang', ));
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

        DB::table('jops')->insert([
            'name' => $request->name,
            'info' => $request->info ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add jop',
            'created_at' => now(),
        ]);

        return redirect()->route('jobs.index')
            ->with('success', 'تم إضافة الوظيفة بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('jobs.index')
                ->with('error', 'معرف الوظيفة مطلوب');
        }

        $job = DB::table('jops')->where('id', $id)->first();
        if (!$job) {
            return redirect()->route('jobs.index')
                ->with('error', 'الوظيفة غير موجودة');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::jobs.edit', compact('job', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('jobs.index')
                ->with('error', 'معرف الوظيفة مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('jops')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'info' => $request->info ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('jobs.index')
            ->with('success', 'تم تحديث الوظيفة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('jobs.index')
                ->with('error', 'معرف الوظيفة مطلوب');
        }

        // Check if job is used by employees
        $employeesCount = DB::table('employees')
            ->where('jop', $id)
            ->count();

        if ($employeesCount > 0) {
            return redirect()->route('jobs.index')
                ->with('error', 'لا يمكن حذف الوظيفة لأنها مستخدمة من قبل موظفين');
        }

        // Soft delete
        DB::table('jops')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('jobs.index')
            ->with('success', 'تم حذف الوظيفة بنجاح');
    }
}