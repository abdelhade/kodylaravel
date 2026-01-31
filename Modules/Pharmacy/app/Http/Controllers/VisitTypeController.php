<?php

namespace Modules\Pharmacy\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VisitTypeController extends Controller
{
    public function index()
    {
        $visitTypes = DB::table('visittybes')
            ->where('isdeleted', '!=', 1)
            ->orderBy('id')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::visit-types.index', compact('visitTypes', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'value' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('visittybes')->insert([
            'name' => $request->name,
            'value' => $request->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add vtybe',
            'created_at' => now(),
        ]);

        return redirect()->route('visit-types.index')
            ->with('success', 'تم إضافة نوع الزيارة بنجاح');
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف نوع الزيارة مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'value' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('visittybes')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'value' => $request->value,
                'updated_at' => now(),
            ]);

        return redirect()->route('visit-types.index')
            ->with('success', 'تم تحديث نوع الزيارة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف نوع الزيارة مطلوب');
        }

        // Soft delete
        DB::table('visittybes')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('visit-types.index')
            ->with('success', 'تم حذف نوع الزيارة بنجاح');
    }
}