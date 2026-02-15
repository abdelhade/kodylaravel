<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        $units = DB::table('myunits')->orderBy('id', 'asc')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::units.index', compact('units', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uname' => 'required|string|min:3|max:255',
        ], [
            'uname.min' => 'يجب أن يكون الاسم 3 أحرف على الأقل',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('myunits')->insert([
            'uname' => $request->uname,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add unit',
            'created_at' => now(),
        ]);

        return redirect()->route('units.index')
            ->with('success', 'تم إضافة الوحدة بنجاح');
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الوحدة مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'uname' => 'required|string|min:3|max:255',
        ], [
            'uname.min' => 'يجب أن يكون الاسم 3 أحرف على الأقل',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('myunits')
            ->where('id', $id)
            ->update([
                'uname' => $request->uname,
                'updated_at' => now(),
            ]);

        return redirect()->route('units.index')
            ->with('success', 'تم تحديث الوحدة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الوحدة مطلوب');
        }

        // Check if unit is used in items before deleting
        $itemExists = DB::table('myitems')->where('unit', $id)->exists();
        if ($itemExists) {
            return redirect()->back()->with('error', 'لا يمكن حذف الوحدة لأنها مستخدمة في بعض الأصناف');
        }

        DB::table('myunits')->where('id', $id)->delete();

        DB::table('process')->insert([
            'type' => 'delete unit',
            'created_at' => now(),
        ]);

        return redirect()->route('units.index')
            ->with('success', 'تم حذف الوحدة بنجاح');
    }
}