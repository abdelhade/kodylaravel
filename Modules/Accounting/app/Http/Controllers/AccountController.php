<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\SidebarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Account types configuration.
     */
    protected function getAccountTypes()
    {
        return [
            'clients' => [
                'name' => 'العملاء',
                'prefix' => '122',
                'icon' => 'fa-users',
                'color' => 'azure',
                'parent_id' => 122,
                'is_person' => true
            ],
            'suppliers' => [
                'name' => 'الموردين',
                'prefix' => '211',
                'icon' => 'fa-truck',
                'color' => 'indigo',
                'parent_id' => 211,
                'is_person' => false
            ],
            'funds' => [
                'name' => 'الخزائن والعهود',
                'prefix' => '121',
                'icon' => 'fa-money-bill-wave',
                'color' => 'emerald',
                'parent_id' => 121,
                'is_person' => false
            ],
            'banks' => [
                'name' => 'البنوك',
                'prefix' => '124',
                'icon' => 'fa-university',
                'color' => 'blue',
                'parent_id' => 124,
                'is_person' => false
            ],
            'expenses' => [
                'name' => 'المصروفات',
                'prefix' => '44',
                'icon' => 'fa-minus-circle',
                'color' => 'rose',
                'parent_id' => 44,
                'is_person' => false
            ],
            'revenues' => [
                'name' => 'الإيرادات',
                'prefix' => '32',
                'icon' => 'fa-plus-circle',
                'color' => 'amber',
                'parent_id' => 32,
                'is_person' => false
            ],
            'stores' => [
                'name' => 'المخازن',
                'prefix' => '123',
                'icon' => 'fa-warehouse',
                'color' => 'orange',
                'parent_id' => 123,
                'is_person' => false
            ],
            'employees' => [
                'name' => 'الموظفين',
                'prefix' => '213',
                'icon' => 'fa-user-tie',
                'color' => 'slate',
                'parent_id' => 213,
                'is_person' => true
            ],
            // مدينين متنوعين / آخرين
            'other_debtors' => [
                'name' => 'مدينين متنوعين',
                'prefix' => '125',
                'icon' => 'fa-user-plus',
                'color' => 'teal',
                'parent_id' => 125,
                'is_person' => false
            ],
            // دائنين متنوعين / آخرين
            'other_creditors' => [
                'name' => 'دائنين متنوعين',
                'prefix' => '212',
                'icon' => 'fa-user-minus',
                'color' => 'fuchsia',
                'parent_id' => 212,
                'is_person' => false
            ],
            // الشركاء
            'partners' => [
                'name' => 'الشركاء',
                'prefix' => '221',
                'icon' => 'fa-handshake',
                'color' => 'cyan',
                'parent_id' => 221,
                'is_person' => true
            ],
            // الأصول (الحساب الرئيسي 1)
            'assets' => [
                'name' => 'الاصول',
                'prefix' => '1',
                'icon' => 'fa-landmark',
                'color' => 'lime',
                'parent_id' => 1,
                'is_person' => false
            ],
            // الأصول القابلة للتأجير (112)
            'rentable_assets' => [
                'name' => 'الاصول القابلة للتأجير',
                'prefix' => '112',
                'icon' => 'fa-building',
                'color' => 'emerald',
                'parent_id' => 112,
                'is_person' => false
            ]
        ];
    }

    /**
     * Display a listing of accounts.
     */
    public function index(Request $request)
    {
        $accType = $request->get('acc');
        $types = $this->getAccountTypes();
        
        $query = DB::table('acc_head')->where('isdeleted', '<', 1);

        $context = null;
        if ($accType && isset($types[$accType])) {
            $context = $types[$accType];
            $query->where('code', 'like', $context['prefix'] . '%')->where('is_basic', 0);
        }

        $accounts = $query->orderBy('code')->get();
        
        // Update balances (logic from AccountReportController)
        DB::statement("UPDATE acc_head SET balance = ( SELECT SUM(journal_entries.debit)- SUM(journal_entries.credit) FROM journal_entries WHERE journal_entries.account_id = acc_head.id AND journal_entries.isdeleted = 0 )");

        // Build tree structure (only for general view)
        $treeAccounts = !$accType ? $this->buildAccountTree(DB::table('acc_head')->where('isdeleted', '<', 1)->get()) : [];

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::accounts.index', compact('accounts', 'treeAccounts', 'settings', 'lang', 'accType', 'context'));
    }

    /**
     * Show the form for creating a new account.
     */
    public function create(Request $request)
    {
        $accType = $request->get('acc');
        $types = $this->getAccountTypes();
        $context = ($accType && isset($types[$accType])) ? $types[$accType] : null;

        $parentId = $request->get('parent_id') ?? ($context['prefix'] ?? null);
        $parent = 0;
        $lastId = "";

        if ($parentId) {
            $parent = $parentId;
            
            // Get last account code with this parent prefix
            $lastAccount = DB::table('acc_head')
                ->where('code', 'like', $parent . '%')
                ->where('is_basic', 0)
                ->orderBy('code', 'desc') // Optimized to use code sort
                ->first();

            if ($lastAccount) {
                $currentMax = substr($lastAccount->code, strlen($parent));
                $nextNum = (int)$currentMax + 1;
                $lastId = $parent . sprintf("%03d", $nextNum);
            } else {
                $lastId = $parent . "001";
            }
        }

        $parentAccounts = DB::table('acc_head')
            ->where('is_basic', 1)
            ->when($parentId, function($q) use ($parentId) {
                return $q->where('code', 'like', $parentId . '%');
            })
            ->orderBy('code')
            ->get();

        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::accounts.create', compact('parent', 'lastId', 'parentAccounts', 'settings', 'lang', 'accType', 'context'));
    }

    /**
     * Store a newly created account.
     */
    public function store(Request $request)
    {
        $accType = $request->get('acc');

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:acc_head,code',
            'aname' => 'required|string|max:255|unique:acc_head,aname',
            'is_basic' => 'required|in:0,1',
            'parent_id' => 'required|exists:acc_head,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get kind from parent
        $parentAccount = DB::table('acc_head')->where('id', $request->parent_id)->first();
        $kind = $parentAccount->kind ?? '';

        // Insert account
        $accountId = DB::table('acc_head')->insertGetId([
            'code' => $request->code,
            'aname' => $request->aname,
            'is_basic' => $request->is_basic,
            'rentable' => $request->has('rentable') ? 1 : 0,
            'is_fund' => $request->has('is_fund') ? 1 : 0,
            'parent_id' => $request->parent_id,
            'is_stock' => $request->has('is_stock') ? 1 : 0,
            'secret' => $request->has('secret') ? 1 : 0,
            'kind' => $kind,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Log process
        DB::table('process')->insert([
            'type' => 'add account >> ' . $request->aname,
            'created_at' => now(),
        ]);

        return redirect()->route('accounts.index', ['acc' => $accType])
            ->with('success', 'تم إضافة الحساب بنجاح');
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $accType = $request->get('acc');
        $types = $this->getAccountTypes();
        $context = ($accType && isset($types[$accType])) ? $types[$accType] : null;

        if (!$id) {
            return redirect()->route('accounts.index', ['acc' => $accType])->with('error', 'معرف الحساب مطلوب');
        }

        $account = DB::table('acc_head')->where('id', $id)->first();
        if (!$account) {
            return redirect()->route('accounts.index', ['acc' => $accType])->with('error', 'الحساب غير موجود');
        }

        $parentAccounts = DB::table('acc_head')->where('is_basic', 1)->orderBy('code')->get();
        $settings = SidebarHelper::getSettings();
        $lang = SidebarHelper::getLanguageVariables($settings['lang'] ?? 'ar');

        return view('accounting::accounts.edit', compact('account', 'parentAccounts', 'settings', 'lang', 'accType', 'context'));
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        $accType = $request->get('acc');

        $validator = Validator::make($request->all(), [
            'aname' => 'required|string|max:255|unique:acc_head,aname,' . $id,
            'parent_id' => 'required|exists:acc_head,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $parentAccount = DB::table('acc_head')->where('id', $request->parent_id)->first();
        $kind = $parentAccount->kind ?? '';

        DB::table('acc_head')
            ->where('id', $id)
            ->update([
                'aname' => $request->aname,
                'is_fund' => $request->has('is_fund') ? 1 : 0,
                'rentable' => $request->has('rentable') ? 1 : 0,
                'is_stock' => $request->has('is_stock') ? 1 : 0,
                'secret' => $request->has('secret') ? 1 : 0,
                'kind' => $kind,
                'phone' => $request->phone ?? null,
                'address' => $request->address ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('accounts.index', ['acc' => $accType])
            ->with('success', 'تم تحديث الحساب بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $accType = $request->get('acc');

        if (!$id) {
            return redirect()->route('accounts.index', ['acc' => $accType])->with('error', 'معرف الحساب مطلوب');
        }

        // Check for transactions
        $hasTransactions = DB::table('journal_entries')->where('account_id', $id)->where('isdeleted', 0)->exists();
        if ($hasTransactions) {
            return redirect()->back()->with('error', 'لا يمكن حذف الحساب لوجود عمليات مالية مرتبطة به');
        }

        DB::table('acc_head')->where('id', $id)->update([
            'isdeleted' => 1,
            'updated_at' => now(),
        ]);

        return redirect()->route('accounts.index', ['acc' => $accType])
            ->with('success', 'تم حذف الحساب بنجاح');
    }

    private function buildAccountTree($accounts, $parentId = 0, $level = 0)
    {
        $tree = [];
        foreach ($accounts as $account) {
            if ($account->parent_id == $parentId) {
                $account->children = $this->buildAccountTree($accounts, $account->id, $level + 1);
                $account->level = $level;
                $tree[] = $account;
            }
        }
        return $tree;
    }
}