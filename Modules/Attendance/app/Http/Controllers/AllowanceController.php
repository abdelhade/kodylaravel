<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AllowanceController extends Controller
{
    public function index()
    {
        $allowances = DB::table('allowances')
            ->whereNull('isdeleted')
            ->orWhere('isdeleted', 0)
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::allowances.index', compact('allowances', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::allowances.create', compact('settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'tybe' => 'required|in:0,1',
            'info' => 'nullable|string|max:250',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('allowances')->insert([
            'name' => $request->name,
            'tybe' => $request->tybe,
            'info' => $request->info ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add allownces',
            'created_at' => now(),
        ]);

        return redirect()->route('allowances.index')
            ->with('success', 'تم إضافة البدل/الاستقطاع بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف البدل/الاستقطاع مطلوب');
        }

        $allowance = DB::table('allowances')
            ->where('id', $id)
            ->first();

        if (!$allowance) {
            return redirect()->route('allowances.index')
                ->with('error', 'البدل/الاستقطاع غير موجود');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('attendance::allowances.edit', compact('allowance', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف البدل/الاستقطاع مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'tybe' => 'required|in:0,1',
            'info' => 'nullable|string|max:250',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('allowances')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'tybe' => $request->tybe,
                'info' => $request->info ?? '',
                'updated_at' => now(),
            ]);

        return redirect()->route('allowances.index')
            ->with('success', 'تم تحديث البدل/الاستقطاع بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف البدل/الاستقطاع مطلوب');
        }

        // Soft delete
        DB::table('allowances')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('allowances.index')
            ->with('success', 'تم حذف البدل/الاستقطاع بنجاح');
    }
}