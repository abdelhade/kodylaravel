<?php

namespace Modules\Pharmacy\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = DB::table('prescs')
            ->where('isdeleted', '!=', 1)
            ->orderBy('id', 'desc')
            ->get();

        // Enrich with client names and prescription details
        foreach ($prescriptions as $prescription) {
            $client = DB::table('clients')->where('id', $prescription->client)->first();
            $prescription->client_name = $client->name ?? 'غير معروف';

            // Get first drug name for display
            $firstDetail = DB::table('prescdetails')
                ->where('prescid', $prescription->id)
                ->where('isdeleted', '!=', 1)
                ->first();
            
            if ($firstDetail) {
                $drug = DB::table('drugs')->where('id', $firstDetail->drug)->first();
                $prescription->first_drug = $drug->name ?? '';
            } else {
                $prescription->first_drug = '';
            }
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::prescriptions.index', compact('prescriptions', 'settings', 'lang', ));
    }

    public function show(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->back()->with('error', 'معرف الوصفة مطلوب');
        }

        $prescription = DB::table('prescs')->where('id', $id)->first();
        if (!$prescription) {
            return redirect()->back()->with('error', 'الوصفة غير موجودة');
        }

        // Get client info
        $client = DB::table('clients')->where('id', $prescription->client)->first();
        
        // Get prescription details (drugs)
        $prescriptionDetails = DB::table('prescdetails')
            ->where('prescid', $id)
            ->where('isdeleted', '!=', 1)
            ->get();

        // Get drug names
        foreach ($prescriptionDetails as $detail) {
            $drug = DB::table('drugs')->where('id', $detail->drug)->first();
            $detail->drug_name = $drug->name ?? '';
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::prescriptions.show', compact('prescription', 'client', 'prescriptionDetails', 'settings', 'lang', ));
    }

    public function create(Request $request)
    {
        $clientId = $request->get('id'); // Client ID from query param
        
        if (!$clientId) {
            return redirect()->back()->with('error', 'معرف العميل مطلوب');
        }

        $client = DB::table('clients')->where('id', $clientId)->first();
        if (!$client) {
            return redirect()->back()->with('error', 'العميل غير موجود');
        }

        // Get last visit for this client
        $lastVisit = DB::table('reservations')
            ->where('client', $clientId)
            ->orderBy('id', 'desc')
            ->first();

        $drugs = DB::table('drugs')->where('isdeleted', '!=', 1)->orderBy('name')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('pharmacy::prescriptions.create', compact('client', 'lastVisit', 'drugs', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $clientId = $request->get('id');
        
        $validator = Validator::make($request->all(), [
            'analyses' => 'nullable|string|max:500',
            'drug' => 'nullable|array',
            'drug.*' => 'exists:drugs,id',
            'dose' => 'nullable|array',
            'dose.*' => 'string|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get last visit for this client
        $lastVisit = DB::table('reservations')
            ->where('client', $clientId)
            ->orderBy('id', 'desc')
            ->first();

        $visitId = $lastVisit->id ?? null;

        // Create prescription
        $prescriptionId = DB::table('prescs')->insertGetId([
            'client' => $clientId,
            'visit' => $visitId,
            'analayses' => $request->analyses ?? null,
            'info' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add prescription details (drugs)
        if ($request->has('drug') && is_array($request->drug)) {
            foreach ($request->drug as $index => $drugId) {
                if ($drugId && isset($request->dose[$index])) {
                    DB::table('prescdetails')->insert([
                        'prescid' => $prescriptionId,
                        'drug' => $drugId,
                        'dose' => $request->dose[$index] ?? '',
                        'info' => '',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        DB::table('process')->insert([
            'type' => 'add presc',
            'created_at' => now(),
        ]);

        return redirect()->route('prescriptions.show', ['id' => $prescriptionId])
            ->with('success', 'تم إضافة الوصفة بنجاح');
    }
}