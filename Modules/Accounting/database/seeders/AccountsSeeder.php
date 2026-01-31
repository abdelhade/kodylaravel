<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to avoid duplicates
        DB::table('acc_head')->truncate();

        $now = now();

        $accounts = [
            // Level 1: Main Categories
            ['id' => 1, 'code' => '1', 'aname' => 'الأصول', 'parent_id' => 0, 'is_basic' => 1, 'kind' => 1, 'nature' => 1],
            ['id' => 2, 'code' => '2', 'aname' => 'الخصوم', 'parent_id' => 0, 'is_basic' => 1, 'kind' => 1, 'nature' => 2],
            ['id' => 3, 'code' => '3', 'aname' => 'الإيرادات', 'parent_id' => 0, 'is_basic' => 1, 'kind' => 2, 'nature' => 2],
            ['id' => 4, 'code' => '4', 'aname' => 'المصروفات', 'parent_id' => 0, 'is_basic' => 1, 'kind' => 2, 'nature' => 1],

            // Level 2: Sub-categories
            // Assets
            ['id' => 11, 'code' => '11', 'aname' => 'الأصول الثابتة', 'parent_id' => 1, 'is_basic' => 1, 'kind' => 1, 'nature' => 1],
            ['id' => 12, 'code' => '12', 'aname' => 'الأصول المتداولة', 'parent_id' => 1, 'is_basic' => 1, 'kind' => 1, 'nature' => 1],
            
            // Liabilities
            ['id' => 21, 'code' => '21', 'aname' => 'الالتزامات المتداولة', 'parent_id' => 2, 'is_basic' => 1, 'kind' => 1, 'nature' => 2],
            ['id' => 22, 'code' => '22', 'aname' => 'حقوق الملكية', 'parent_id' => 2, 'is_basic' => 1, 'kind' => 1, 'nature' => 2],

            // Level 3: Specialized Categories (Used by Polymorphic system)
            // Under Assets -> Current Assets
            ['id' => 121, 'code' => '121', 'aname' => 'الخزائن والعهود', 'parent_id' => 12, 'is_basic' => 1, 'kind' => 1, 'nature' => 1],
            ['id' => 122, 'code' => '122', 'aname' => 'العملاء', 'parent_id' => 12, 'is_basic' => 1, 'kind' => 1, 'nature' => 1],
            ['id' => 123, 'code' => '123', 'aname' => 'المخازن', 'parent_id' => 12, 'is_basic' => 1, 'kind' => 1, 'nature' => 1],
            ['id' => 124, 'code' => '124', 'aname' => 'البنوك', 'parent_id' => 12, 'is_basic' => 1, 'kind' => 1, 'nature' => 1],
            ['id' => 125, 'code' => '125', 'aname' => 'المدينون المتنوعون', 'parent_id' => 12, 'is_basic' => 1, 'kind' => 1, 'nature' => 1],

            // Under Liabilities -> Current Liabilities
            ['id' => 211, 'code' => '211', 'aname' => 'الموردين', 'parent_id' => 21, 'is_basic' => 1, 'kind' => 1, 'nature' => 2],
            ['id' => 212, 'code' => '212', 'aname' => 'الدائنون المتنوعون', 'parent_id' => 21, 'is_basic' => 1, 'kind' => 1, 'nature' => 2],
            ['id' => 213, 'code' => '213', 'aname' => 'موظفين (أمانات)', 'parent_id' => 21, 'is_basic' => 1, 'kind' => 1, 'nature' => 2],

            // Under Revenues (Main)
            ['id' => 31, 'code' => '31', 'aname' => 'إيرادات مبيعات', 'parent_id' => 3, 'is_basic' => 1, 'kind' => 2, 'nature' => 2],
            ['id' => 32, 'code' => '32', 'aname' => 'إيرادات أخرى', 'parent_id' => 3, 'is_basic' => 1, 'kind' => 2, 'nature' => 2],

            // Under Expenses (Main)
            ['id' => 41, 'code' => '41', 'aname' => 'تكلفة المبيعات', 'parent_id' => 4, 'is_basic' => 1, 'kind' => 2, 'nature' => 1],
            ['id' => 44, 'code' => '44', 'aname' => 'مصروفات تشغيلية', 'parent_id' => 4, 'is_basic' => 1, 'kind' => 2, 'nature' => 1],

            // Level 4: Initial Default Sub-accounts (Ready to use)
            ['id' => 1001, 'code' => '121001', 'aname' => 'الخزينة الرئيسية', 'parent_id' => 121, 'is_basic' => 0, 'kind' => 1, 'nature' => 1, 'is_fund' => 1],
            ['id' => 1002, 'code' => '122001', 'aname' => 'عميل نقدي', 'parent_id' => 122, 'is_basic' => 0, 'kind' => 1, 'nature' => 1],
            ['id' => 1003, 'code' => '123001', 'aname' => 'المخزن الرئيسي', 'parent_id' => 123, 'is_basic' => 0, 'kind' => 1, 'nature' => 1, 'is_stock' => 1],
            ['id' => 1004, 'code' => '211001', 'aname' => 'مورد نقدي', 'parent_id' => 211, 'is_basic' => 0, 'kind' => 1, 'nature' => 2],
        ];

        foreach ($accounts as $account) {
            DB::table('acc_head')->insert(array_merge($account, [
                'created_at' => $now,
                'updated_at' => $now,
                'deletable' => 0,
                'editable' => 0,
                'isdeleted' => 0,
            ]));
        }
    }
}
