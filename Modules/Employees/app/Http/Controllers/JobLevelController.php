<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobLevelController extends Controller
{
    public function index()
    {
        $levels = DB::table('joplevels')
            ->whereNull('isdeleted')
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::job-levels.index', compact('levels', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::job-levels.create', compact('settings', 'lang', ));
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

        DB::table('joplevels')->insert([
            'name' => $request->name,
            'info' => $request->info ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add jop level',
            'created_at' => now(),
        ]);

        return redirect()->route('job-levels.index')
            ->with('success', 'تم إضافة مستوى الوظيفة بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المستوى مطلوب');
        }

        $level = DB::table('joplevels')->where('id', $id)->first();
        if (!$level) {
            return redirect()->back()->with('error', 'المستوى غير موجود');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::job-levels.edit', compact('level', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المستوى مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('joplevels')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'info' => $request->info ?? '',
                'updated_at' => now(),
            ]);

        return redirect()->route('job-levels.index')
            ->with('success', 'تم تحديث مستوى الوظيفة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المستوى مطلوب');
        }

        // Soft delete
        DB::table('joplevels')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('job-levels.index')
            ->with('success', 'تم حذف مستوى الوظيفة بنجاح');
    }
}