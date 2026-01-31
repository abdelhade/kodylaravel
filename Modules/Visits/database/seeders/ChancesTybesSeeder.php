<?php

namespace Modules\Visits\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChancesTybesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'cname' => 'جديد',
                'info' => null,
                'crtime' => '2023-11-28 01:20:13',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 2,
                'cname' => 'تم الاتفاق',
                'info' => null,
                'crtime' => '2023-11-28 01:27:21',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 3,
                'cname' => 'دفع عربون',
                'info' => null,
                'crtime' => '2023-11-28 01:27:21',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 4,
                'cname' => 'صفقه تامه',
                'info' => null,
                'crtime' => '2023-11-28 01:27:42',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
        ];

        foreach ($data as $row) {
            DB::table('chances_tybes')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
