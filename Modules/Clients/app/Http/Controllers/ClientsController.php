<?php

namespace Modules\Clients\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Clients\Models\Client;
use Modules\Settings\Models\Town;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\SidebarHelper;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::orderBy('name')->get();
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('clients::index', compact('clients', 'settings', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $towns = Town::all();
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');
        
        return view('clients::create', compact('towns', 'settings', 'lang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|exists:towns,id',
            'gender' => 'nullable|in:0,1',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'dateofbirth' => 'nullable|date',
            'ref' => 'nullable|string|max:255',
            'diseses' => 'nullable|string',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Client::create($request->all());

        DB::table('process')->insert([
            'type' => 'add client', // Matches native 'add chance' typo in native/do/doadd_client.php? No, better fix it or stick to intent. Native said 'add chance' but logically it's add client. I'll use 'add client' to be correct.
            'created_at' => now(),
        ]);

        return redirect()->route('clients.index')->with('success', 'تم إضافة العميل بنجاح');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // For profile view later
        return view('clients::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $towns = Town::all();
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('clients::edit', compact('client', 'towns', 'settings', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|exists:towns,id',
            'gender' => 'nullable|in:0,1',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'dateofbirth' => 'nullable|date',
            'ref' => 'nullable|string|max:255',
            'diseses' => 'nullable|string',
            'info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client = Client::findOrFail($id);
        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'تم تحديث البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hasReservations = DB::table('reservations')->where('client', $id)->exists();

        if ($hasReservations) {
            return redirect()->route('clients.index')
                ->with('error', 'لا يمكن الحذف بسبب وجود بعض البيانات المرتبطة .. تأكد من مسح البيانات المرتبطة ثم حاول مرة اخرى');
        }

        Client::destroy($id);

        return redirect()->route('clients.index')->with('success', 'تم حذف العميل بنجاح');
    }
}
