<?php

namespace Modules\Pharmacy\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DrugController extends Controller
{
    public function index()
    {
        $drugs = DB::table('drugs')
            ->orderBy('name', 'asc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::drugs.index', compact('drugs', 'settings', 'lang', ));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::drugs.create', compact('settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:drugs,name',
            'effectivematerial' => 'nullable|string|max:255',
            'purpose' => 'nullable|string',
            'sideeffects' => 'nullable|string',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = session('userid');

        DB::table('drugs')->insert([
            'name' => $request->name,
            'effectivematerial' => $request->effectivematerial ?? null,
            'purpose' => $request->purpose ?? null,
            'sideeffects' => $request->sideeffects ?? null,
            'info' => $request->info ?? null,
            'user' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add drug',
            'created_at' => now(),
        ]);

        return redirect()->route('drugs.index')
            ->with('success', 'تم إضافة الدواء بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('drugs.index')
                ->with('error', 'معرف الدواء مطلوب');
        }

        $drug = DB::table('drugs')->where('id', $id)->first();
        if (!$drug) {
            return redirect()->route('drugs.index')
                ->with('error', 'الدواء غير موجود');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::drugs.edit', compact('drug', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('drugs.index')
                ->with('error', 'معرف الدواء مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:drugs,name,' . $id,
            'effectivematerial' => 'nullable|string|max:255',
            'purpose' => 'nullable|string',
            'sideeffects' => 'nullable|string',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('drugs')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'effectivematerial' => $request->effectivematerial ?? null,
                'purpose' => $request->purpose ?? null,
                'sideeffects' => $request->sideeffects ?? null,
                'info' => $request->info ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('drugs.index')
            ->with('success', 'تم تحديث الدواء بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('drugs.index')
                ->with('error', 'معرف الدواء مطلوب');
        }

        // Check if drug is used in prescriptions
        $prescriptionsCount = DB::table('prescdetails')
            ->where('drug', $id)
            ->count();

        if ($prescriptionsCount > 0) {
            return redirect()->route('drugs.index')
                ->with('error', 'لا يمكن حذف الدواء لأنه مستخدم في وصفات طبية');
        }

        DB::table('drugs')->where('id', $id)->delete();

        return redirect()->route('drugs.index')
            ->with('success', 'تم حذف الدواء بنجاح');
    }
}