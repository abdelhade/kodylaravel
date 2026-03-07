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
        // Based on the actual migration file columns
        return [
            // Users
            'is_fav_users', 'show_users', 'add_users', 'edit_users', 'delete_users',
            
            // General Entries (not in form but in DB)
            'is_fav_general_entrys', 'show_general_entrys', 'add_general_entrys', 'edit_general_entrys', 'delete_general_entrys',
            
            // Clients
            'is_fav_clients', 'show_clients', 'add_clients', 'edit_clients', 'delete_clients',
            
            // Suppliers
            'is_fav_suppliers', 'show_suppliers', 'add_suppliers', 'edit_suppliers', 'delete_suppliers',
            
            // Funds
            'is_fav_funds', 'show_funds', 'add_funds', 'edit_funds', 'delete_funds',
            
            // Banks
            'is_fav_banks', 'show_banks', 'add_banks', 'edit_banks', 'delete_banks',
            
            // Stock
            'is_fav_stock', 'show_stock', 'add_stock', 'edit_stock', 'delete_stock',
            
            // Expenses
            'is_fav_expenses', 'show_expenses', 'add_expenses', 'edit_expenses', 'delete_expenses',
            
            // Revenuses
            'is_fav_revenuses', 'show_revenuses', 'add_revenuses', 'edit_revenuses', 'delete_revenuses',
            
            // Credits
            'is_fav_credits', 'show_credits', 'add_credits', 'edit_credits', 'delete_credits',
            
            // Depits
            'is_fav_depits', 'show_depits', 'add_depits', 'edit_depits', 'delete_depits',
            
            // Partners
            'is_fav_partners', 'show_partners', 'add_partners', 'edit_partners', 'delete_partners',
            
            // Assets
            'is_fav_assets', 'show_assets', 'add_assets', 'edit_assets', 'delete_assets',
            
            // Rentables
            'is_fav_rentables', 'show_rentables', 'add_rentables', 'edit_rentables', 'delete_rentables',
            
            // Employees
            'is_fav_employees', 'show_employees', 'add_employees', 'edit_employees', 'delete_employees',
            
            // Items
            'is_fav_items', 'show_items', 'add_items', 'edit_items', 'delete_items',
            
            // Item Groups
            'is_fav_item_groups', 'show_item_groups', 'add_item_groups', 'edit_item_groups', 'delete_item_groups',
            
            // Sales
            'is_fav_sales', 'show_sales', 'add_sales', 'edit_sales', 'delete_sales',
            
            // Resale
            'is_fav_resale', 'show_resale', 'add_resale', 'edit_resale', 'delete_resale',
            
            // Purchases (note: is_fav_purcases is a typo in DB)
            'is_fav_purcases', 'show_purchases', 'add_purchases', 'edit_purchases', 'delete_purchases',
            
            // Repurchases
            'is_fav_repurchases', 'show_repurchases', 'add_repurchases', 'edit_repurchases', 'delete_repurchases',
            
            // Recive
            'is_fav_recive', 'show_recive', 'add_recive', 'edit_recive', 'delete_recive',
            
            // Payment
            'show_payment', 'is_fav_payment', 'add_payment', 'edit_payment', 'delete_payment',
            
            // Clinic Clients (clinics in form)
            'is_fav_clinic_clients', 'show_clinic_clients', 'add_clinic_clients', 'edit_clinic_clients', 'delete_clinic_clients',
            
            // Reservations
            'is_fav_reservations', 'show_reservations', 'add_reservations', 'edit_reservations', 'delete_reservations',
            
            // Drugs
            'is_fav_drugs', 'show_drugs', 'add_drugs', 'edit_drugs', 'delete_drugs',
            
            // Attandance
            'is_fav_attandance', 'show_attandance', 'add_attandance', 'edit_attandance', 'delete_attandance',
            
            // Client Profile
            'is_fav_client_profile', 'show_client_profile', 'add_client_profile', 'edit_client_profile', 'delete_client_profile',
            
            // Advanced Clients
            'is_fav_advanced_clients', 'show_advanced_clients', 'add_advanced_clients', 'edit_advanced_clients', 'delete_advanced_clients',
            
            // Chances
            'is_fav_chances', 'show_chances', 'add_chances', 'edit_chances', 'delete_chances',
            
            // Calls
            'is_fav_calls', 'show_calls', 'add_calls', 'edit_calls', 'delete_calls',
            
            // Journals
            'is_fav_journals', 'show_journals', 'add_journals', 'edit_journals', 'delete_journals',
            
            // Reports (show only)
            'show_gl_reports', 'show_clinic_reports', 'show_rent_reports', 'show_payroll_report', 'show_hr_report',
            
            // Sidebar options
            'sid_entry', 'sid_stock', 'sid_sales', 'sid_purchases', 'sid_vouchers', 'sid_clinics', 
            'sid_crm', 'sid_accounts', 'sid_assets', 'sid_reports', 'sid_hr', 'sid_payroll', 'sid_rents',
            
            // General options
            'show_total_reservation', 'show_ended_reservation', 'show_all_tasks', 
            'show_main_cards', 'show_main_elements', 'show_main_tables',
        ];
    }

    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        // Get current user role permissions from database
        $userRoleId = session('usrole') ?? $_SESSION['usrole'] ?? null;
        
        $role = ['show_users' => 1]; // Default to allow access
        
        if ($userRoleId) {
            $roleData = DB::table('usr_pwrs')
                ->where('id', $userRoleId)
                ->first();
            
            if ($roleData) {
                // Convert to array for blade compatibility
                $role = (array) $roleData;
                
                // Ensure show_users key exists
                if (!isset($role['show_users'])) {
                    $role['show_users'] = 1;
                }
            }
        }

        $roles = DB::table('usr_pwrs')
            ->where('isdeleted', '!=', 1)
            ->select('id', 'rollname', 'info')
            ->orderBy('id', 'desc')
            ->get();

        return view('users::roles.index', compact('roles', 'settings', 'lang', 'role'));
    }

    public function create()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        // Get current user role permissions from database
        $userRoleId = session('usrole') ?? $_SESSION['usrole'] ?? null;
        
        $role = ['show_users' => 1, 'add_users' => 1]; // Default to allow access
        
        if ($userRoleId) {
            $roleData = DB::table('usr_pwrs')
                ->where('id', $userRoleId)
                ->first();
            
            if ($roleData) {
                // Convert to array for blade compatibility
                $role = (array) $roleData;
                
                // Ensure required keys exist
                if (!isset($role['show_users'])) {
                    $role['show_users'] = 1;
                }
                if (!isset($role['add_users'])) {
                    $role['add_users'] = 1;
                }
            }
        }

        return view('users::roles.create', compact('settings', 'lang', 'role'));
    }

    public function store(Request $request)
    {
        \Log::info('=== Role Store Started ===');
        
        $validator = Validator::make($request->all(), [
            'rollname' => 'required|string|max:255',
            'info' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed', ['errors' => $validator->errors()]);
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

        // Mapping for form fields to database columns (where they differ)
        $fieldMapping = [
            'show_clinics' => 'show_clinic_clients',
            'add_clinics' => 'add_clinic_clients',
            'edit_clinics' => 'edit_clinic_clients',
            'delete_clinics' => 'delete_clinic_clients',
            'is_fav_clinics' => 'is_fav_clinic_clients',
            'is_fav_purchases' => 'is_fav_purcases', // Typo in database
        ];

        // Add all permission columns
        foreach ($this->getPermissionColumns() as $column) {
            // Check if this column has a different name in the form
            $formField = array_search($column, $fieldMapping);
            if ($formField !== false) {
                // Use the form field name to check if it exists
                $data[$column] = $request->has($formField) ? 1 : 0;
            } else {
                // Use the column name directly
                $data[$column] = $request->has($column) ? 1 : 0;
            }
        }

        \Log::info('Data prepared for insert', ['data_count' => count($data)]);

        try {
            $inserted = DB::table('usr_pwrs')->insert($data);
            \Log::info('Insert result', ['inserted' => $inserted]);

            DB::table('process')->insert([
                'type' => 'add role',
                'created_at' => now(),
            ]);

            \Log::info('=== Role Store Completed Successfully ===');

            return redirect()->route('roles.index')
                ->with('success', 'تم إضافة الدور بنجاح');
        } catch (\Exception $e) {
            \Log::error('Exception occurred', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إضافة الدور: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        
        if (!$id) {
            return redirect()->route('roles.index')
                ->with('error', 'معرف الدور مطلوب');
        }

        // Verify hash for security (as in original code)
        $hash_id = md5($id);
        $hash = $request->input('hash');
        
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

        // Get current user role permissions
        $userRoleId = session('usrole') ?? $_SESSION['usrole'] ?? null;
        
        $role = ['show_users' => 1, 'edit_users' => 1]; // Default to allow access
        
        if ($userRoleId) {
            $currentRoleData = DB::table('usr_pwrs')
                ->where('id', $userRoleId)
                ->first();
            
            if ($currentRoleData) {
                // Convert to array for blade compatibility
                $role = (array) $currentRoleData;
                
                // Ensure required keys exist
                if (!isset($role['show_users'])) {
                    $role['show_users'] = 1;
                }
                if (!isset($role['edit_users'])) {
                    $role['edit_users'] = 1;
                }
            }
        }

        return view('users::roles.edit', compact('roleData', 'settings', 'lang', 'role'));
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
