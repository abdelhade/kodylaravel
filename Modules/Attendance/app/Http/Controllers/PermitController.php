<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermitController extends Controller
{
    /**
     * Display permits index page.
     */
    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        // Check if user has permission to view attendance
        $role = SidebarHelper::getUserRole();
        if (!isset($role['show_attandance']) || $role['show_attandance'] != 1) {
            abort(403, 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        // Get permits if table exists
        $permits = [];
        try {
            $permits = DB::table('permits')
                ->where('isdeleted', '!=', 1)
                ->orWhereNull('isdeleted')
                ->orderBy('id', 'desc')
                ->get();
        } catch (\Exception $e) {
            // Table might not exist yet
        }

        return view('attendance::permits.index', compact('permits', 'settings', 'lang'));
    }
}
