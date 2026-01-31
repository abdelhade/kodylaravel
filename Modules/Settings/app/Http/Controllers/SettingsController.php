<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Show settings page with password check
     */
    public function index(Request $request)
    {
        // Check if password is provided
        if (!$request->has('password') || !$request->filled('password')) {
            return view('settings::password-check');
        }

        // Get settings password from language file or settings table
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        // Get password from language file or settings table
        $sittingpass = $lang['sittingpass'] ?? $settings['edit_pass'] ?? 'hadi@1234';
        
        // Verify password
        if ($request->password != $sittingpass) {
            return view('settings::password-check', [
                'error' => 'كلمة المرور غير صحيحة'
            ]);
        }

        // Get all settings
        $settingsData = DB::table('settings')->first();
        
        // Get accounts for dropdowns
        $accounts = DB::table('acc_head')
            ->where('isdeleted', '<', 1)
            ->orderBy('aname')
            ->get();


        return view('settings::index', compact('settingsData', 'accounts', 'settings', 'lang', ));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companyname' => 'required|string|max:200',
            'companyadd' => 'nullable|string|max:200',
            'companytel' => 'nullable|string|max:200',
            'edit_pass' => 'nullable|string|max:50',
            'lang' => 'required|string|max:20',
            'bodycolor' => 'nullable|string|max:50',
            'acc_rent' => 'nullable|integer',
            'def_pos_client' => 'nullable|integer',
            'def_pos_store' => 'nullable|integer',
            'def_pos_employee' => 'nullable|integer',
            'def_pos_fund' => 'nullable|integer',
            'showhr' => 'nullable|integer',
            'showatt' => 'nullable|integer',
            'showclinc' => 'nullable|integer',
            'showrent' => 'nullable|integer',
            'showpayroll' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update settings (there's only one row with id=1)
        DB::table('settings')
            ->where('id', 1)
            ->update([
                'company_name' => $request->companyname,
                'company_add' => $request->companyadd ?? null,
                'company_tel' => $request->companytel ?? null,
                'edit_pass' => $request->edit_pass ?? null,
                'lang' => $request->lang,
                'bodycolor' => $request->bodycolor ?? null,
                'acc_rent' => $request->acc_rent ?? 0,
                'def_pos_client' => $request->def_pos_client ?? null,
                'def_pos_store' => $request->def_pos_store ?? null,
                'def_pos_employee' => $request->def_pos_employee ?? null,
                'def_pos_fund' => $request->def_pos_fund ?? null,
                'showhr' => $request->showhr ?? 1,
                'showatt' => $request->showatt ?? 1,
                'showclinc' => $request->showclinc ?? 1,
                'showrent' => $request->showrent ?? 1,
                'showpayroll' => $request->showpayroll ?? 1,
                'updated_at' => now(),
            ]);

        // Clear settings cache
        \Illuminate\Support\Facades\Cache::forget('system_settings');

        return redirect()->route('kody2.dashboard')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}