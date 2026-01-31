<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::orders.index', compact('settings', 'lang', ));
    }

    public function create(Request $request)
    {
        $orderTypeId = $request->get('id');
        
        $employees = DB::table('employees')->orderBy('name')->get();
        $orderTypes = DB::table('order_types')->orderBy('name')->get();
        $orderStatuses = DB::table('order_status')->orderBy('name')->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('employees::orders.create', compact('employees', 'orderTypes', 'orderStatuses', 'orderTypeId', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee' => 'required|exists:employees,id',
            'tybe' => 'required|exists:order_types,id',
            'status' => 'required|exists:order_status,id',
            'applyingdate' => 'required|date',
            'curdate' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('orders')->insert([
            'employee' => $request->employee,
            'tybe' => $request->tybe,
            'status' => $request->status,
            'applyingdate' => $request->applyingdate,
            'curdate' => $request->curdate,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('process')->insert([
            'type' => 'add order',
            'created_at' => now(),
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'تم إضافة الطلب بنجاح');
    }
}