<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Helpers\SidebarHelper;

class MainDashboardController extends Controller
{
    public function index()
    {
        if (!session('login')) {
            return redirect()->route('login');
        }
        
        // Get settings from database (using helper with caching)
        $settings = SidebarHelper::getSettings();
        
        // Get user data for sidebar (using helper with caching)
        $userData = SidebarHelper::getUserData();
        
        // Load language file (with caching)
        $langCode = $settings['lang'] ?? 'ar';
        $cacheKey = "language_{$langCode}";
        
        $lang = Cache::remember($cacheKey, 3600, function () use ($langCode) {
            $lang = [];
            $langFile = base_path("native/language/{$langCode}.php");
            if (file_exists($langFile)) {
                // Capture variables from language file
                ob_start();
                include $langFile;
                ob_end_clean();
                // Get all variables that start with $lang_
                $allVars = get_defined_vars();
                foreach ($allVars as $key => $value) {
                    if (strpos($key, 'lang_') === 0 || strpos($key, 'sittingpass') === 0) {
                        $lang[$key] = $value;
                    }
                }
            }
            return $lang;
        });
        
        // Get role permissions
        $role = SidebarHelper::getRole();
        
        // Get statistics
        $stats = [
            'due_installments' => 0,
            'clients' => DB::table('acc_head')->where('is_basic', 0)
                ->where('isdeleted', 0)
                ->where('code', 'like', '122%')
                ->count(),
            'sessions' => 0,
            'sales_count' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->count(),
            'sales_total' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->sum('fat_net'),
            'tasks' => 0,
            'pending_tasks' => 0,
            'reservations' => 0,
        ];
        
        // Get recent accounts for main_tables
        $recentAccounts = DB::table('acc_head')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get()
            ->map(function($account) {
                $parent = DB::table('acc_head')->where('id', $account->parent_id)->first();
                $account->parent_name = $parent ? $parent->aname : '-';
                return $account;
            });
        
        // Get recent operations
        $recentOperations = DB::table('ot_head')
            ->where('isdeleted', 0)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get()
            ->map(function($op) {
                $type = DB::table('pro_tybes')->where('id', $op->pro_tybe)->first();
                $op->type_name = $type ? $type->pname : '-';
                return $op;
            });
        
        // Get recent items
        $recentItems = DB::table('myitems')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        
        // Get recent sessions
        $recentSessions = []; // Table session_time doesn't exist
        
        // Get sales statistics
        $salesStats = [
            'last_invoice' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->where('isdeleted', 0)->orderBy('id', 'desc')->value('fat_net'),
            'last_week' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->where('isdeleted', 0)->whereBetween('pro_date', [now()->subDays(7), now()])->sum('fat_net'),
            'last_month' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->where('isdeleted', 0)->whereBetween('pro_date', [now()->subDays(30), now()])->sum('fat_net'),
            'total' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->where('isdeleted', 0)->sum('fat_net'),
        ];
        
        // Get recent reservations
        $recentReservations = [];
        
        // Get due installments
        $dueInstallments = [];
        
        // Sync Laravel session with native $_SESSION for compatibility
        if (!isset($_SESSION)) {
            $_SESSION = [];
        }
        $sessionData = Session::all();
        foreach ($sessionData as $key => $value) {
            $_SESSION[$key] = $value;
        }
        
        return view('dashboard.main', compact(
            'settings', 
            'lang', 
            'stats', 
            'recentAccounts', 
            'userData',
            'role',
            'recentOperations',
            'recentItems',
            'recentSessions',
            'salesStats',
            'recentReservations',
            'dueInstallments'
        ));
    }
}
