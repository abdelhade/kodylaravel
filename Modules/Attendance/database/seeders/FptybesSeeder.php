<?php

namespace Modules\Attendance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FptybesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'حضور',
                'crtime' => '2023-07-31 22:57:14',
                'isdeleted' => null,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 2,
                'name' => 'انصراف',
                'crtime' => '2023-07-31 22:57:14',
                'isdeleted' => null,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 3,
                'name' => 'حضور اضافي',
                'crtime' => '2023-07-31 22:57:42',
                'isdeleted' => null,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 4,
                'name' => 'انصراف اضافي',
                'crtime' => '2023-07-31 22:58:34',
                'isdeleted' => null,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 5,
                'name' => 'invalid',
                'crtime' => '2023-08-10 04:45:50',
                'isdeleted' => null,
                'tenant' => 0,
                'branch' => 0,
            ],
        ];

        foreach ($data as $row) {
            DB::table('fptybes')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
