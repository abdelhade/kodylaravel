<?php

namespace Modules\Pharmacy\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of patients (clients).
     */
    public function index(Request $request)
    {
        $patients = DB::table('clients')
            ->orderBy('name', 'asc')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::patients.index', compact('patients', 'settings', 'lang', ));
    }
}