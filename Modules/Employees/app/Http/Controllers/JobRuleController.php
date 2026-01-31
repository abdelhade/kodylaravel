<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobRuleController extends Controller
{
    public function index()
    {
        $rules = DB::table('joprules')
            ->whereNull('isdeleted')
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::job-rules.index', compact('rules', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::job-rules.create', compact('settings', 'lang', ));
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

        DB::table('joprules')->insert([
            'name' => $request->name,
            'info' => $request->info ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add jop rule',
            'created_at' => now(),
        ]);

        return redirect()->route('job-rules.index')
            ->with('success', 'تم إضافة قاعدة الوظيفة بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف القاعدة مطلوب');
        }

        $rule = DB::table('joprules')->where('id', $id)->first();
        if (!$rule) {
            return redirect()->back()->with('error', 'القاعدة غير موجودة');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::job-rules.edit', compact('rule', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف القاعدة مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('joprules')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'info' => $request->info ?? '',
                'updated_at' => now(),
            ]);

        return redirect()->route('job-rules.index')
            ->with('success', 'تم تحديث قاعدة الوظيفة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف القاعدة مطلوب');
        }

        // Soft delete
        DB::table('joprules')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('job-rules.index')
            ->with('success', 'تم حذف قاعدة الوظيفة بنجاح');
    }
}