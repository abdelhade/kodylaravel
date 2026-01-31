<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function index()
    {
        $groups = DB::table('item_group')
            ->where('isdeleted', 0)
            ->orderBy('id', 'asc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('inventory::groups.index', compact('groups', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gname' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('item_group')->insert([
            'gname' => $request->gname,
            'isdeleted' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add group',
            'created_at' => now(),
        ]);

        return redirect()->route('groups.index')
            ->with('success', 'تم إضافة المجموعة بنجاح');
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المجموعة مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'gname' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('item_group')
            ->where('id', $id)
            ->update([
                'gname' => $request->gname,
                'updated_at' => now(),
            ]);

        return redirect()->route('groups.index')
            ->with('success', 'تم تحديث المجموعة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف المجموعة مطلوب');
        }

        // Soft delete
        DB::table('item_group')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('groups.index')
            ->with('success', 'تم حذف المجموعة بنجاح');
    }
}