<?php

namespace Modules\CRM\Http\Controllers;

use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = DB::table('crm_activities')
            ->leftJoin('crm_activity_types', 'crm_activities.type_id', '=', 'crm_activity_types.id')
            ->leftJoin('crm_leads', function($join) {
                $join->on('crm_activities.related_id', '=', 'crm_leads.id')
                     ->where('crm_activities.related_to', '=', 'lead');
            })
            ->select('crm_activities.*', 'crm_activity_types.name as type_name', 'crm_leads.name as lead_name')
            ->orderBy('crm_activities.activity_date', 'desc')
            ->get();

        $types = DB::table('crm_activity_types')->orderBy('name')->get();
        $leads = DB::table('crm_leads')->orderBy('name')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('crm::activities.index', compact('activities', 'types', 'leads', 'settings', 'lang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type_id' => 'required|exists:crm_activity_types,id',
            'related_to' => 'required|string',
            'related_id' => 'required|integer',
            'activity_date' => 'required|date',
            'duration' => 'nullable|integer',
            'description' => 'nullable|string',
            'status' => 'nullable|in:planned,completed,cancelled',
        ]);

        DB::table('crm_activities')->insert([
            'title' => $validated['title'],
            'type_id' => $validated['type_id'],
            'related_to' => $validated['related_to'],
            'related_id' => $validated['related_id'],
            'activity_date' => $validated['activity_date'],
            'duration' => $validated['duration'] ?? 0,
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'] ?? 'planned',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('activities.index');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'type_id' => 'required|exists:crm_activity_types,id',
            'lead_id' => 'nullable|exists:crm_leads,id',
            'activity_date' => 'required|date',
            'duration' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        DB::table('crm_activities')->where('id', $id)->update([
            'subject' => $validated['subject'],
            'type_id' => $validated['type_id'],
            'lead_id' => $validated['lead_id'] ?? null,
            'activity_date' => $validated['activity_date'],
            'duration' => $validated['duration'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('activities.index');
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');
        DB::table('crm_activities')->where('id', $id)->delete();

        return redirect()->route('activities.index');
    }
}
