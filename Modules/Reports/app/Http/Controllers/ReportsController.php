<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display reports index page
     */
    public function index(Request $request)
    {
        $type = $request->get('t');
        $title = "الكل";
        
        if ($type == 'rents') {
            $title = 'التأجير';
        } elseif ($type == 'acc') {
            $title = 'الحسابات';
        }

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('reports::index', compact('title', 'type', 'settings', 'lang', ));
    }

    /**
     * Display account summary report
     */
    public function clinicReports()
    {
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('reports::clinic-reports', compact('settings', 'lang', ));
    }

    public function summary(Request $request)
    {
        $accounts = DB::table('acc_head')
            ->where('is_basic', 0)
            ->where('isdeleted', '<', 1)
            ->orderBy('aname')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        $accountId = $request->get('acc_id') ?? $request->post('acc_id');
        $startDate = $request->post('startdate') ?? $settings['startdate'] ?? date('Y-01-01');
        $endDate = $request->post('enddate') ?? $settings['enddate'] ?? date('Y-12-31');

        $accountData = null;
        $transactions = [];
        $accountBalance = 0;

        if ($accountId && $accountId != 0) {
            // Get account info
            $accountData = DB::table('acc_head')->where('id', $accountId)->first();
            $accountBalance = $accountData->balance ?? 0;

            // Get transactions
            $transactions = DB::table('ot_head')
                ->where(function($query) use ($accountId) {
                    $query->where('acc1', $accountId)
                          ->orWhere('acc2', $accountId);
                })
                ->where('isdeleted', 0)
                ->whereBetween('pro_date', [$startDate, $endDate])
                ->orderBy('pro_date')
                ->get();

            // Get transaction details
            foreach ($transactions as $transaction) {
                $transaction->type_name = '';
                if ($transaction->pro_tybe) {
                    $typeData = DB::table('pro_tybes')->where('id', $transaction->pro_tybe)->first();
                    $transaction->type_name = $typeData->pname ?? '';
                }

                // Get debit/credit amounts
                $journalEntries = DB::table('journal_entries')
                    ->where(function($query) use ($transaction) {
                        $query->where('op_id', $transaction->id)
                              ->orWhere('op2', $transaction->id);
                    })
                    ->get();

                $transaction->debit = 0;
                $transaction->credit = 0;
                $transaction->counter_account = '';

                if ($transaction->acc1 == $accountId) {
                    $debitEntry = $journalEntries->where('debit', '>', 0)->first();
                    $transaction->debit = $debitEntry->debit ?? 0;
                    
                    // Get counter account
                    if ($transaction->acc2) {
                        $counterAcc = DB::table('acc_head')->where('id', $transaction->acc2)->first();
                        $transaction->counter_account = $counterAcc->aname ?? '';
                    }
                } elseif ($transaction->acc2 == $accountId) {
                    $creditEntry = $journalEntries->where('credit', '>', 0)->first();
                    $transaction->credit = $creditEntry->credit ?? 0;
                    
                    // Get counter account
                    if ($transaction->acc1) {
                        $counterAcc = DB::table('acc_head')->where('id', $transaction->acc1)->first();
                        $transaction->counter_account = $counterAcc->aname ?? '';
                    }
                }
            }
        }

        return view('reports::summary', compact(
            'accounts', 
            'accountId', 
            'startDate', 
            'endDate', 
            'accountData', 
            'transactions', 
            'accountBalance',
            'settings', 
            'lang', 
            ));
    }
}