<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RentController extends Controller
{
    // rentables.php - عرض الوحدات الإيجارية
    public function index()
    {
        $rentables = DB::table('acc_head')
            ->where(function($query) {
                $query->where('rentable', 1)
                      ->orWhere('rentable', 2);
            })
            ->where('is_basic', 0)
            ->get();

        // Get rent details for rented units (rentable = 2)
        foreach ($rentables as $rentable) {
            if ($rentable->rentable == 2) {
                $rent = DB::table('myrents')
                    ->where('rent_id', $rentable->id)
                    ->where('isdeleted', 0)
                    ->first();
                
                if ($rent) {
                    $client = DB::table('acc_head')
                        ->where('id', $rent->cl_id)
                        ->first();
                    
                    $rentable->rent_details = $rent;
                    $rentable->client = $client;
                }
            }
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::rents.index', compact('rentables', 'settings', 'lang', ));
    }

    // myrentables.php - عرض المدد الإيجارية (الأقساط)
    public function installments()
    {
        $start = DB::table('myrents')
            ->where('isdeleted', 0)
            ->min('start_date');
        
        $end = DB::table('myrents')
            ->where('isdeleted', 0)
            ->max('end_date');

        $installments = DB::table('myinstallments')
            ->orderBy('ins_date')
            ->get();

        // Enrich with unit and client names
        foreach ($installments as $installment) {
            $unit = DB::table('acc_head')
                ->where('id', $installment->rent_id)
                ->first();
            $installment->unit_name = $unit->aname ?? '';

            $client = DB::table('acc_head')
                ->where('id', $installment->cl_id)
                ->first();
            $installment->client_name = $client->aname ?? '';

            // Check if expired
            $installment->is_expired = Carbon::parse($installment->ins_date)->isPast();
            $installment->is_paid = ($installment->ins_value == $installment->ins_paid);
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::rents.installments', compact('installments', 'start', 'end', 'settings', 'lang', ));
    }

    // add_rent.php - إضافة/تعديل عقد إيجار
    public function create(Request $request)
    {
        $rentId = $request->get('id'); // For editing existing rent
        $rent = null;

        if ($rentId) {
            $rent = DB::table('myrents')
                ->where('rent_id', $rentId)
                ->where('isdeleted', 0)
                ->first();
        }

        // Get clients (code like '122%')
        $clients = DB::table('acc_head')
            ->where('code', 'like', '122%')
            ->where('is_basic', 0)
            ->get();

        // Get rentable units (code like '112%', rentable = 1)
        $rentableUnits = DB::table('acc_head')
            ->where('is_basic', 0)
            ->where('rentable', 1)
            ->where('code', 'like', '112%')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::rents.create', compact('rent', 'clients', 'rentableUnits', 'rentId', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cl_id' => 'required|exists:acc_head,id',
            'rent_id' => 'required|exists:acc_head,id',
            'phone' => 'nullable|string|min:6',
            'idintity' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pay_tybe' => 'required|in:0,1,2',
            'r_value' => 'required|numeric|min:0.01',
            'bnd1' => 'nullable|string|max:250',
            'bnd2' => 'nullable|string|max:250',
            'bnd3' => 'nullable|string|max:250',
            'bnd4' => 'nullable|string|max:250',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validate rent value > 0
        if ($request->r_value <= 0) {
            return redirect()->back()
                ->with('error', 'يجب أن تكون قيمة الإيجار أكبر من صفر')
                ->withInput();
        }

        // Insert rent contract
        $contractId = DB::table('myrents')->insertGetId([
            'cl_id' => $request->cl_id,
            'rent_id' => $request->rent_id,
            'phone' => $request->phone,
            'idintity' => $request->idintity,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'pay_tybe' => $request->pay_tybe,
            'r_value' => $request->r_value,
            'bnd1' => $request->bnd1 ?? '',
            'bnd2' => $request->bnd2 ?? '',
            'bnd3' => $request->bnd3 ?? '',
            'bnd4' => $request->bnd4 ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create installments based on pay_tybe
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $installmentValue = $request->r_value;

        // Create monthly installments (as per original logic)
        $currentDate = $startDate->copy()->startOfMonth();
        while ($currentDate->lte($endDate)) {
            DB::table('myinstallments')->insert([
                'cl_id' => $request->cl_id,
                'rent_id' => $request->rent_id,
                'contract' => $contractId,
                'ins_value' => $installmentValue,
                'ins_date' => $currentDate->format('Y-m-01'),
                'ins_case' => 1,
                'ins_paid' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $currentDate->addMonth();
        }

        // Update unit status to rented (rentable = 2)
        DB::table('acc_head')
            ->where('id', $request->rent_id)
            ->update(['rentable' => 2]);

        DB::table('process')->insert([
            'type' => 'add rent',
            'created_at' => now(),
        ]);

        return redirect()->route('rents.create', ['id' => $request->rent_id])
            ->with('success', 'تم تسجيل عقد الإيجار بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $rentId = $request->get('r');

        if (!$id || !$rentId) {
            return redirect()->back()->with('error', 'معرف العقد مطلوب');
        }

        // Delete installments
        DB::table('myinstallments')
            ->where('contract', $id)
            ->delete();

        // Soft delete rent
        DB::table('myrents')
            ->where('id', $id)
            ->update([
                'isdeleted' => 1,
                'updated_at' => now(),
            ]);

        // Update unit status to available (rentable = 1)
        DB::table('acc_head')
            ->where('id', $rentId)
            ->update(['rentable' => 1]);

        return redirect()->route('rents.index')
            ->with('success', 'تم إخلاء الوحدة وحذف العقد بنجاح');
    }
}