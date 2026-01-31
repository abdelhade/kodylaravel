<?php

namespace Modules\Reservations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $showEnded = $request->get('c') == 1;
        
        $startDate = $request->get('startdate', date('Y-m-d'));
        $endDate = $request->get('enddate', date('Y-m-d'));


        $query = DB::table('reservations')
            ->whereBetween('date', [$startDate, $endDate]);

        if ($showEnded) {
            $query->where('ended', 1);
        } else {
            $query->where('ended', '!=', 1);
        }

        $reservations = $query->orderBy('date', 'desc')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('reservations::reservations.index', compact('reservations', 'showEnded', 'startDate', 'endDate', 'settings', 'lang', ));
    }

    public function create()
    {
        $clients = DB::table('clients')->orderBy('name')->get();
        $rentables = DB::table('acc_head')
            ->where('rentable', 1)
            ->where('isdeleted', '<', 1)
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('reservations::reservations.create', compact('clients', 'rentables', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => 'required|string|max:255',
            'date' => 'required|date',
            'rentable' => 'required|exists:acc_head,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('reservations')->insert([
            'client' => $request->client,
            'date' => $request->date,
            'rentable' => $request->rentable,
            'info' => $request->info ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'تم إضافة الحجز بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('reservations.index')
                ->with('error', 'معرف الحجز مطلوب');
        }

        $reservation = DB::table('reservations')->where('id', $id)->first();
        if (!$reservation) {
            return redirect()->route('reservations.index')
                ->with('error', 'الحجز غير موجود');
        }

        $clients = DB::table('clients')->orderBy('name')->get();
        $rentables = DB::table('acc_head')
            ->where('rentable', 1)
            ->where('isdeleted', '<', 1)
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('reservations::reservations.edit', compact('reservation', 'clients', 'rentables', 'settings', 'lang', ));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('reservations.index')
                ->with('error', 'معرف الحجز مطلوب');
        }

        $validator = Validator::make($request->all(), [
            'client' => 'required|string|max:255',
            'date' => 'required|date',
            'rentable' => 'required|exists:acc_head,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('reservations')
            ->where('id', $id)
            ->update([
                'client' => $request->client,
                'date' => $request->date,
                'rentable' => $request->rentable,
                'info' => $request->info ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('reservations.index')
            ->with('success', 'تم تحديث الحجز بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return redirect()->route('reservations.index')
                ->with('error', 'معرف الحجز مطلوب');
        }

        DB::table('reservations')->where('id', $id)->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'تم حذف الحجز بنجاح');
    }
}