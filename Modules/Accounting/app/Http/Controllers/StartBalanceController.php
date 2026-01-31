<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StartBalanceController extends Controller
{
    public function index()
    {
        // Get basic accounts for filter
        $basicAccounts = DB::table('acc_head')
            ->where('isdeleted', 0)
            ->where('is_basic', 1)
            ->orderBy('code')
            ->get();

        // Get all non-basic accounts
        $accounts = DB::table('acc_head')
            ->where('isdeleted', 0)
            ->where('is_basic', 0)
            ->orderBy('code')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::start-balance.index', compact('basicAccounts', 'accounts', 'settings', 'lang', ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'acc_id' => 'required|array',
            'acc_id.*' => 'required|exists:acc_head,id',
            'newbalance' => 'required|array',
            'newbalance.*' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update balances for each account
        foreach ($request->acc_id as $index => $accountId) {
            if (isset($request->newbalance[$index])) {
                DB::table('acc_head')
                    ->where('id', $accountId)
                    ->update([
                        'balance' => $request->newbalance[$index],
                        'updated_at' => now(),
                    ]);
            }
        }

        DB::table('process')->insert([
            'type' => 'update start balance',
            'created_at' => now(),
        ]);

        return redirect()->route('start-balance.index')
            ->with('success', 'تم حفظ الأرصدة الافتتاحية بنجاح');
    }
}