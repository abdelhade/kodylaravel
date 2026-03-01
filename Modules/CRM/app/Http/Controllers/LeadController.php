<?php

namespace Modules\CRM\Http\Controllers;

use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    public function index()
    {
        $leads = DB::table('crm_leads')
            ->leftJoin('crm_lead_sources', 'crm_leads.source_id', '=', 'crm_lead_sources.id')
            ->leftJoin('crm_lead_statuses', 'crm_leads.status_id', '=', 'crm_lead_statuses.id')
            ->select('crm_leads.*', 'crm_lead_sources.name as source_name', 'crm_lead_statuses.name as status_name')
            ->orderBy('crm_leads.created_at', 'desc')
            ->get();

        $sources = DB::table('crm_lead_sources')->orderBy('name')->get();
        $statuses = DB::table('crm_lead_statuses')->orderBy('order')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('crm::leads.index', compact('leads', 'sources', 'statuses', 'settings', 'lang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'source_id' => 'required|exists:crm_lead_sources,id',
            'status_id' => 'required|exists:crm_lead_statuses,id',
            'notes' => 'nullable|string',
        ]);

        DB::table('crm_leads')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'source_id' => $validated['source_id'],
            'status_id' => $validated['status_id'],
            'notes' => $validated['notes'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('leads.index');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'source_id' => 'required|exists:crm_lead_sources,id',
            'status_id' => 'required|exists:crm_lead_statuses,id',
            'notes' => 'nullable|string',
        ]);

        DB::table('crm_leads')->where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'source_id' => $validated['source_id'],
            'status_id' => $validated['status_id'],
            'notes' => $validated['notes'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('leads.index');
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');
        DB::table('crm_leads')->where('id', $id)->delete();

        return redirect()->route('leads.index');
    }
}
