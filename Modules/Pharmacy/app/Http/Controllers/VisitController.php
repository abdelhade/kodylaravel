<?php

namespace Modules\Pharmacy\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
    public function index()
    {
        $visits = DB::table('visits')
            ->where('isdeleted', '!=', 1)
            ->orderBy('id', 'desc')
            ->get();

        // Get client info for each visit
        foreach ($visits as $visit) {
            $client = DB::table('clients')->where('id', $visit->client)->first();
            $visit->client_name = $client->name ?? '';
            $visit->client_age = $client->dateofbirth ?? '';
            $visit->client_degree = $client->degree ?? '';
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::visits.index', compact('visits', 'settings', 'lang', ));
    }

    public function create()
    {
        $clients = DB::table('clients')->where('isdeleted', '!=', 1)->orderBy('name')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::visits.create', compact('clients', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => 'required|exists:clients,id',
            'complaint' => 'required|string|max:500',
            'diagnosis' => 'nullable|string|max:500',
            'recommendation' => 'nullable|string|max:500',
            'prescription' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = session('userid');

        DB::table('visits')->insert([
            'client' => $request->client,
            'complaint' => $request->complaint,
            'diagnosis' => $request->diagnosis ?? null,
            'recommendation' => $request->recommendation ?? null,
            'prescription' => $request->prescription ?? null,
            'info' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add visit',
            'created_at' => now(),
        ]);

        return redirect()->route('visits.index')
            ->with('success', 'تم إضافة الزيارة بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الزيارة مطلوب');
        }

        $visit = DB::table('visits')->where('id', $id)->first();
        if (!$visit) {
            return redirect()->back()->with('error', 'الزيارة غير موجودة');
        }

        $client = DB::table('clients')->where('id', $visit->client)->first();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::visits.edit', compact('visit', 'client', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الزيارة مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'complaint' => 'required|string|max:500',
            'diagnosis' => 'nullable|string|max:500',
            'recommendation' => 'nullable|string|max:500',
            'prescription' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('visits')
            ->where('id', $id)
            ->update([
                'complaint' => $request->complaint,
                'diagnosis' => $request->diagnosis ?? null,
                'recommendation' => $request->recommendation ?? null,
                'prescription' => $request->prescription ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('visits.index')
            ->with('success', 'تم تحديث الزيارة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الزيارة مطلوب');
        }

        // Soft delete
        DB::table('visits')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        return redirect()->route('visits.index')
            ->with('success', 'تم حذف الزيارة بنجاح');
    }
}