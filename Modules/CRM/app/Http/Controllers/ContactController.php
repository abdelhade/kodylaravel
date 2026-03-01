<?php

namespace Modules\CRM\Http\Controllers;

use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = DB::table('crm_contacts')
            ->leftJoin('crm_leads', 'crm_contacts.lead_id', '=', 'crm_leads.id')
            ->select('crm_contacts.*', 'crm_leads.name as lead_name')
            ->orderBy('crm_contacts.created_at', 'desc')
            ->get();

        $leads = DB::table('crm_leads')->orderBy('name')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('crm::contacts.index', compact('contacts', 'leads', 'settings', 'lang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:255',
            'lead_id' => 'nullable|exists:crm_leads,id',
            'notes' => 'nullable|string',
        ]);

        DB::table('crm_contacts')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'position' => $validated['position'] ?? null,
            'lead_id' => $validated['lead_id'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('contacts.index');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:255',
            'lead_id' => 'nullable|exists:crm_leads,id',
            'notes' => 'nullable|string',
        ]);

        DB::table('crm_contacts')->where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'position' => $validated['position'] ?? null,
            'lead_id' => $validated['lead_id'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('contacts.index');
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');
        DB::table('crm_contacts')->where('id', $id)->delete();

        return redirect()->route('contacts.index');
    }
}
