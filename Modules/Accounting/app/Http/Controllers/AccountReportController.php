<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountReportController extends Controller
{
    public function index(Request $request)
    {
        // Update balances first (same as original code)
        DB::statement("UPDATE acc_head SET balance = ( SELECT SUM(journal_entries.debit)- SUM(journal_entries.credit) FROM journal_entries WHERE journal_entries.account_id = acc_head.id AND journal_entries.isdeleted = 0 )");

        // Get filter parameters
        $accType = $request->get('acc');
        $filterCondition = "";
        $code = null;
        $parentId = null;
        $accountName = "";

        // Build filter condition based on account type
        if ($accType) {
            switch ($accType) {
                case 'clients':
                    $filterCondition = " AND code LIKE '122%' ";
                    $code = 122;
                    $parentId = 122;
                    break;
                case 'suppliers':
                    $filterCondition = " AND code LIKE '211%' ";
                    $code = 211;
                    $parentId = 211;
                    break;
                case 'funds':
                    $filterCondition = " AND code LIKE '121%' ";
                    $code = 121;
                    $parentId = 121;
                    break;
                case 'banks':
                    $filterCondition = " AND code LIKE '124%' ";
                    $code = 124;
                    $parentId = 124;
                    break;
                case 'expenses':
                    $filterCondition = " AND code LIKE '44%' ";
                    $code = 44;
                    $parentId = 44;
                    break;
                case 'revenous':
                    $filterCondition = " AND code LIKE '32%' ";
                    $code = 32;
                    $parentId = 32;
                    break;
                case 'creditors':
                    $filterCondition = " AND code LIKE '212%' ";
                    $code = 212;
                    $parentId = 212;
                    break;
                case 'depitors':
                    $filterCondition = " AND code LIKE '125%' ";
                    $code = 125;
                    $parentId = 125;
                    break;
                case 'partners':
                    $filterCondition = " AND code LIKE '221%' ";
                    $code = 221;
                    $parentId = 221;
                    break;
                case 'assets':
                    $filterCondition = " AND code LIKE '11%' ";
                    $code = 11;
                    $parentId = 11;
                    break;
                case 'employees':
                    $filterCondition = " AND code LIKE '213%' ";
                    $code = 213;
                    $parentId = 213;
                    break;
                case 'rentable':
                    $filterCondition = " AND code LIKE '112%' ";
                    $code = 112;
                    $parentId = 112;
                    break;
                case 'stores':
                    $filterCondition = " AND code LIKE '123%' ";
                    $code = 123;
                    $parentId = 123;
                    break;
            }

            if ($code) {
                $account = DB::table('acc_head')->where('code', $code)->first();
                $accountName = $account->aname ?? '';
            }
        }

        // Get accounts
        $accounts = DB::table('acc_head')
            ->where('is_basic', 0)
            ->whereRaw("isdeleted = 0 $filterCondition")
            ->orderBy('aname')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::account-report.index', compact('accounts', 'accType', 'accountName', 'parentId', 'settings', 'lang', ));
    }
}