<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KBIController extends Controller
{
    public function index()
    {
        $kbis = DB::table('kbis')
            ->where('isdeleted', 0)
            ->orderBy('id', 'desc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::kbis.index', compact('kbis', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::kbis.create', compact('settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kname' => 'required|string|max:255',
            'ktybe' => 'nullable|string|max:255',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('kbis')->insert([
            'kname' => $request->kname,
            'ktybe' => $request->ktybe ?? '',
            'info' => $request->info ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add kbi',
            'created_at' => now(),
        ]);

        return redirect()->route('kbis.index')
            ->with('success', 'تم إضافة معدل التقييم بنجاح');
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف معدل التقييم مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'kname' => 'required|string|max:255',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'البيانات غير صحيحة');
        }

        DB::table('kbis')
            ->where('id', $id)
            ->update([
                'kname' => $request->kname,
                'info' => $request->info ?? '',
                'updated_at' => now(),
            ]);

        return redirect()->route('kbis.index')
            ->with('success', 'تم تحديث معدل التقييم بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف معدل التقييم مطلوب');
        }

        // Soft delete
        DB::table('kbis')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('kbis.index')
            ->with('success', 'تم حذف معدل التقييم بنجاح');
    }
}