<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    private function getPermissionColumns()
    {
        $prefixes = [
            'users', 'clients', 'suppliers', 'funds', 'banks', 
            'stock', 'expenses', 'revenuses', 'credits', 'depits', 
            'partners', 'assets', 'rentables', 'employees', 'items', 
            'item_groups', 'sales', 'resale', 'purchases', 'repurchases', 
            'recive', 'payment', 'clinics', 'reservations', 'advanced_clients',
            'drugs', 'client_profile', 'attandance', 'chances', 'calls', 
            'journals', 'gl_reports', 'clinic_reports', 'rent_reports', 
            'payroll_report', 'hr_report'
        ];

        $columns = [];
        foreach ($prefixes as $prefix) {
            $columns[] = 'show_' . $prefix;
            $columns[] = 'add_' . $prefix;
            $columns[] = 'edit_' . $prefix;
            $columns[] = 'delete_' . $prefix;
            $columns[] = 'is_fav_' . $prefix;
        }

        $sidebarOptions = [
            'sid_entry', 'sid_stock', 'sid_sales', 'sid_purchases', 
            'sid_vouchers', 'sid_clinics', 'sid_crm', 'sid_accounts', 
            'sid_assets', 'sid_reports', 'sid_hr', 'sid_payroll', 
            'sid_rents', 'sid_cards', 'edit_user_passwords'
        ];

        $generalOptions = [
            'show_ended_reservation', 'show_total_reservation', 
            'show_client_profile', 'show_all_tasks', 'show_main_cards', 
            'show_main_elements', 'show_main_tables'
        ];

        return array_merge($columns, $sidebarOptions, $generalOptions);
    }

    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        $roles = DB::table('usr_pwrs')
            ->where('isdeleted', '!=', 1)
            ->select('id', 'rollname', 'info')
            ->orderBy('id', 'desc')
            ->get();

        return view('users::roles.index', compact('roles', 'settings', 'lang'));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('users::roles.create', compact('settings', 'lang'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rollname' => 'required|string|max:255',
            'info' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare data array with basic info
        $data = [
            'rollname' => $request->rollname,
            'info' => $request->info ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Add all permission columns
        foreach ($this->getPermissionColumns() as $column) {
            $data[$column] = $request->has($column) ? 1 : 0;
        }

        try {
            DB::table('usr_pwrs')->insert($data);

            DB::table('process')->insert([
                'type' => 'add role',
                'created_at' => now(),
            ]);

            return redirect()->route('roles.index')
                ->with('success', 'تم إضافة الدور بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إضافة الدور: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('name');
        
        if (!$id) {
            return redirect()->route('roles.index')
                ->with('error', 'معرف الدور مطلوب');
        }

        // Verify hash for security (as in original code)
        $hash_id = md5($id);
        $hash = $request->get('hash');
        
        if ($hash && $hash_id !== $hash) {
            abort(403, 'غير مسموح بالتلاعب في اللينك');
        }

        $roleData = DB::table('usr_pwrs')
            ->where('id', $id)
            ->first();

        if (!$roleData) {
            return redirect()->route('roles.index')
                ->with('error', 'الدور غير موجود');
        }

        // Verify name if provided
        if ($name && $roleData->rollname !== $name) {
            abort(403, 'غير مسموح بالتلاعب في الاسم');
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('users::roles.edit', compact('roleData', 'settings', 'lang'));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الدور مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'rollname' => 'required|string|max:255',
            'info' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare data array with basic info
        $data = [
            'rollname' => $request->rollname,
            'info' => $request->info ?? '',
            'updated_at' => now(),
        ];

        // Add all permission columns
        foreach ($this->getPermissionColumns() as $column) {
            $data[$column] = $request->has($column) ? 1 : 0;
        }

        try {
            DB::table('usr_pwrs')
                ->where('id', $id)
                ->update($data);

            DB::table('process')->insert([
                'type' => 'edit role',
                'created_at' => now(),
            ]);

            return redirect()->route('roles.index')
                ->with('success', 'تم تحديث الدور بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء تحديث الدور: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الدور مطلوب');
        }

        // Soft delete
        DB::table('usr_pwrs')
            ->where('id', $id)
            ->update(['isdeleted' => 1]);

        DB::table('process')->insert([
            'type' => 'delete role',
            'created_at' => now(),
        ]);

        return redirect()->route('roles.index')->with('success', 'تم حذف الدور بنجاح');
    }
}
