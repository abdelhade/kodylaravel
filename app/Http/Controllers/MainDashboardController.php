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
            'due_installments' => DB::table('myinstallments')->where('ins_case', 2)->count(),
            'clients' => DB::table('acc_head')->where('is_basic', 0)
                ->where('isdeleted', 0)
                ->where('code', 'like', '122%')
                ->count(),
            'sessions' => DB::table('session_time')->count(),
            'sales_count' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->count(),
            'sales_total' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->sum('pro_value'),
            'tasks' => DB::table('tasks')->count(),
            'pending_tasks' => DB::table('tasks')->whereNull('isdeleted')->count(),
            'reservations' => DB::table('reservations')->whereNotNull('duration')->count(),
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
        $recentSessions = DB::table('session_time')
            ->orderBy('crtime', 'desc')
            ->limit(5)
            ->get()
            ->map(function($session) {
                $user = DB::table('users')->where('id', $session->user)->first();
                $session->user_name = $user ? $user->uname : '__';
                return $session;
            });
        
        // Get sales statistics
        $salesStats = [
            'last_invoice' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->where('isdeleted', 0)->orderBy('id', 'desc')->value('pro_value'),
            'last_week' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->where('isdeleted', 0)->whereBetween('pro_date', [now()->subDays(7), now()])->sum('pro_value'),
            'last_month' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->where('isdeleted', 0)->whereBetween('pro_date', [now()->subDays(30), now()])->sum('pro_value'),
            'total' => DB::table('ot_head')->whereIn('pro_tybe', [3, 9])->where('isdeleted', 0)->sum('pro_value'),
        ];
        
        // Get recent reservations
        $recentReservations = DB::table('reservations')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get()
            ->map(function($res) {
                $client = DB::table('clients')->where('id', $res->client)->first();
                $res->client_name = $client ? $client->name : '__';
                return $res;
            });
        
        // Get due installments
        $dueInstallments = DB::table('myinstallments')
            ->where('ins_date', '<', now())
            ->orderBy('ins_date')
            ->limit(5)
            ->get()
            ->map(function($ins) {
                $rent = DB::table('acc_head')->where('id', $ins->rent_id)->first();
                $client = DB::table('acc_head')->where('id', $ins->cl_id)->first();
                $ins->rent_name = $rent ? $rent->aname : '-';
                $ins->client_name = $client ? $client->aname : '-';
                return $ins;
            });
        
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
