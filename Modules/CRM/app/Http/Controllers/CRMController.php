<?php

namespace Modules\CRM\Http\Controllers;

use App\Helpers\SidebarHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class CRMController extends Controller
{
    public function dashboard()
    {
        // إحصائيات العملاء المحتملين
        $totalLeads = DB::table('crm_leads')->count();
        $newLeads = DB::table('crm_leads')
            ->join('crm_lead_statuses', 'crm_leads.status_id', '=', 'crm_lead_statuses.id')
            ->where('crm_lead_statuses.name', 'جديد')
            ->count();
        $qualifiedLeads = DB::table('crm_leads')
            ->join('crm_lead_statuses', 'crm_leads.status_id', '=', 'crm_lead_statuses.id')
            ->where('crm_lead_statuses.name', 'مؤهل')
            ->count();
        $convertedLeads = DB::table('crm_leads')
            ->join('crm_lead_statuses', 'crm_leads.status_id', '=', 'crm_lead_statuses.id')
            ->where('crm_lead_statuses.name', 'تم التحويل')
            ->count();

        // إحصائيات الفرص
        $totalOpportunities = DB::table('crm_opportunities')->count();
        $totalOpportunitiesValue = DB::table('crm_opportunities')->sum('amount');

        // إحصائيات الأنشطة
        $totalActivities = DB::table('crm_activities')->count();
        $todayActivities = DB::table('crm_activities')
            ->whereDate('activity_date', today())
            ->count();

        // أحدث العملاء المحتملين
        $recentLeads = DB::table('crm_leads')
            ->leftJoin('crm_lead_sources', 'crm_leads.source_id', '=', 'crm_lead_sources.id')
            ->leftJoin('crm_lead_statuses', 'crm_leads.status_id', '=', 'crm_lead_statuses.id')
            ->select('crm_leads.*', 'crm_lead_sources.name as source_name', 'crm_lead_statuses.name as status_name', 'crm_lead_statuses.color as status_color')
            ->orderBy('crm_leads.created_at', 'desc')
            ->limit(5)
            ->get();

        // أحدث الفرص
        $recentOpportunities = DB::table('crm_opportunities')
            ->leftJoin('crm_opportunity_stages', 'crm_opportunities.stage_id', '=', 'crm_opportunity_stages.id')
            ->leftJoin('crm_leads', 'crm_opportunities.lead_id', '=', 'crm_leads.id')
            ->select('crm_opportunities.*', 'crm_opportunity_stages.name as stage_name', 'crm_leads.name as lead_name')
            ->orderBy('crm_opportunities.created_at', 'desc')
            ->limit(5)
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('crm::dashboard', compact(
            'totalLeads', 'newLeads', 'qualifiedLeads', 'convertedLeads',
            'totalOpportunities', 'totalOpportunitiesValue',
            'totalActivities', 'todayActivities',
            'recentLeads', 'recentOpportunities',
            'settings', 'lang'
        ));
    }
}
