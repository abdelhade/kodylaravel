<?php

namespace Modules\CRM\Http\Controllers;

use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class OpportunityController extends Controller
{
    public function index()
    {
        $opportunities = DB::table('crm_opportunities')
            ->leftJoin('crm_opportunity_stages', 'crm_opportunities.stage_id', '=', 'crm_opportunity_stages.id')
            ->leftJoin('crm_leads', 'crm_opportunities.lead_id', '=', 'crm_leads.id')
            ->select('crm_opportunities.*', 'crm_opportunity_stages.name as stage_name', 'crm_leads.name as lead_name')
            ->orderBy('crm_opportunities.created_at', 'desc')
            ->get();

        $stages = DB::table('crm_opportunity_stages')->orderBy('order')->get();
        $leads = DB::table('crm_leads')->orderBy('name')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('crm::opportunities.index', compact('opportunities', 'stages', 'leads', 'settings', 'lang'));
    }

    public function create()
    {
        $leads = DB::table('crm_leads')->get();
        $stages = DB::table('crm_opportunity_stages')->get();
        
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('crm::opportunities.create', compact('leads', 'stages', 'settings', 'lang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'lead_id' => 'nullable|exists:crm_leads,id',
            'stage_id' => 'required|exists:crm_opportunity_stages,id',
            'amount' => 'nullable|numeric',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        DB::table('crm_opportunities')->insert([
            'title' => $validated['title'],
            'lead_id' => $validated['lead_id'] ?? null,
            'stage_id' => $validated['stage_id'],
            'amount' => $validated['amount'] ?? null,
            'probability' => $validated['probability'] ?? 0,
            'expected_close_date' => $validated['expected_close_date'] ?? null,
            'description' => $validated['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('opportunities.index')->with('success', 'تم إضافة الفرصة بنجاح');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'lead_id' => 'nullable|exists:crm_leads,id',
            'stage_id' => 'required|exists:crm_opportunity_stages,id',
            'amount' => 'nullable|numeric',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        DB::table('crm_opportunities')->where('id', $id)->update([
            'title' => $validated['title'],
            'lead_id' => $validated['lead_id'] ?? null,
            'stage_id' => $validated['stage_id'],
            'amount' => $validated['amount'] ?? null,
            'probability' => $validated['probability'] ?? 0,
            'expected_close_date' => $validated['expected_close_date'] ?? null,
            'description' => $validated['description'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('opportunities.index')->with('success', 'تم تحديث الفرصة بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->query('id');
        $opportunity = DB::table('crm_opportunities')->where('id', $id)->first();
        
        if (!$opportunity) {
            return redirect()->route('opportunities.index')->with('error', 'الفرصة غير موجودة');
        }

        $leads = DB::table('crm_leads')->get();
        $stages = DB::table('crm_opportunity_stages')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('crm::opportunities.edit', compact('opportunity', 'leads', 'stages', 'settings', 'lang'));
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');
        DB::table('crm_opportunities')->where('id', $id)->delete();

        return redirect()->route('opportunities.index')->with('success', 'تم حذف الفرصة بنجاح');
    }
}
