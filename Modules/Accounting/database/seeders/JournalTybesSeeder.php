<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JournalTybesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'journal_id' => 1,
                'jname' => 'purchases',
                'jtext' => 'يومية المقبوضات',
                'info' => null,
                'crtime' => '2024-03-14 00:34:38',
                'mdtime' => '2024-03-14 00:34:38',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 2,
                'journal_id' => 2,
                'jname' => 'sales',
                'jtext' => 'يومية المدفوعات',
                'info' => null,
                'crtime' => '2024-03-14 00:34:38',
                'mdtime' => '2024-03-14 00:34:38',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 3,
                'journal_id' => 3,
                'jname' => 'Payments',
                'jtext' => 'المبيعات',
                'info' => null,
                'crtime' => '2024-03-14 00:34:38',
                'mdtime' => '2024-03-14 00:34:38',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 4,
                'journal_id' => 4,
                'jname' => 'receipts',
                'jtext' => 'يومية المشتريات',
                'info' => null,
                'crtime' => '2024-03-14 00:34:38',
                'mdtime' => '2024-03-14 00:34:38',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 5,
                'journal_id' => 5,
                'jname' => 'Accrueds',
                'jtext' => 'ايراد مستحق',
                'info' => null,
                'crtime' => '2024-03-14 00:34:38',
                'mdtime' => '2024-03-14 00:34:38',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 6,
                'journal_id' => 6,
                'jname' => 'Accrueds',
                'jtext' => 'خصم مكتسب',
                'info' => null,
                'crtime' => '2024-03-14 00:34:38',
                'mdtime' => '2024-03-14 00:34:38',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 7,
                'journal_id' => 7,
                'jname' => 'Accrueds',
                'jtext' => 'خصم مسموح به',
                'info' => null,
                'crtime' => '2024-03-14 00:34:38',
                'mdtime' => '2024-03-14 00:34:38',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 8,
                'journal_id' => 8,
                'jname' => 'journal',
                'jtext' => 'القيود اليومية',
                'info' => null,
                'crtime' => '2024-03-14 00:34:38',
                'mdtime' => '2024-03-14 00:34:38',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
        ];

        foreach ($data as $row) {
            DB::table('journal_tybes')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
