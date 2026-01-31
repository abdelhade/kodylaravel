<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function index()
    {
        // Check if logo column exists, if not add it
        try {
            $columns = DB::select("SHOW COLUMNS FROM settings LIKE 'logo'");
            if (empty($columns)) {
                DB::statement("ALTER TABLE settings ADD COLUMN logo VARCHAR(255) AFTER branch");
            }
        } catch (\Exception $e) {
            // Column might already exist or table doesn't exist
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        // Get MAC address
        $mac = exec('getmac');
        $mac2 = strtok($mac, ' ');

        $isLicensed = !empty($settings['lic']);

        return view('settings::about.index', compact('settings', 'lang',  'mac', 'mac2', 'isLicensed'));
    }

    public function truncate(Request $request)
    {
        $password = $request->password;
        
        if ($password !== 'hadi@1234') {
            return redirect()->back()->with('error', 'كلمة المرور غير صحيحة');
        }

        $tables = [
            "acc_groups", "allowances", "analisys", "attandance", "attdocs", "attlog",
            "barcodes", "calls", "cases", "chances", "clients", "cost_centers",
            "criminals", "crm_style", "ctp", "cvs", "departments", "drugs",
            "emplog", "employees", "emp_allowences", "extras", "fat_details", "fats",
            "hiringcontracts", "holidays", "imgs", "imporfplog", "item_group",
            "item_group2", "item_group3", "item_units", "joplevels", "joprules", "jops",
            "joptybes", "journal_entries", "journal_heads", "karta", "myinstallments",
            "myitems", "myoper_det", "myrents", "myvouchers", "my_news", "orders",
            "order_status", "order_types", "paper_types", "permits", "prescdetails",
            "prescs", "print", "prods", "pst_activities", "pst_criminals", "pst_crmstyles",
            "pst_gangs", "pst_issues", "rays", "reservations", "salaries", "services",
            "session_time", "skills", "tasks", "test", "transactions", "users",
            "vacancies", "visits", "zankat", "ot_head", "acc_head"
        ];

        DB::beginTransaction();
        try {
            foreach ($tables as $table) {
                if ($table == "users" || $table == "cost_centers") {
                    DB::table($table)->where('id', '>', 1)->delete();
                } elseif ($table == "acc_head") {
                    DB::table($table)->where('deletable', 1)->delete();
                } else {
                    DB::table($table)->truncate();
                }
            }
            DB::table('acc_head')->update(['balance' => 0]);
            
            DB::commit();
            return redirect()->route('about.index')->with('success', 'تم مسح البيانات بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء مسح البيانات: ' . $e->getMessage());
        }
    }

    public function finish(Request $request)
    {
        $password = $request->password;
        
        if ($password !== 'hadi@1234') {
            return redirect()->back()->with('error', 'كلمة المرور غير صحيحة');
        }

        // Similar to truncate but might have different logic
        // For now, redirecting to truncate
        return $this->truncate($request);
    }
}