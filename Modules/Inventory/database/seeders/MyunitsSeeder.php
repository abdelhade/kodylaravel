<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MyunitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'uname' => 'قطعه',
                'crtime' => '2024-03-25 05:56:49',
                'mdtime' => '2024-03-25 05:56:49',
                'isdeleted' => null,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 2,
                'uname' => 'كرتونة ',
                'crtime' => '2024-03-25 05:59:05',
                'mdtime' => '2025-02-26 17:16:20',
                'isdeleted' => null,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 3,
                'uname' => 'دسته',
                'crtime' => '2024-03-25 05:59:12',
                'mdtime' => '2024-03-25 06:13:25',
                'isdeleted' => null,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 4,
                'uname' => 'باله',
                'crtime' => '2024-07-25 03:26:22',
                'mdtime' => '2024-07-25 03:26:30',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 5,
                'uname' => 'قطعه',
                'crtime' => '2024-07-28 20:36:16',
                'mdtime' => '2024-07-28 20:36:16',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 6,
                'uname' => 'م',
                'crtime' => '2024-09-22 16:54:45',
                'mdtime' => '2024-09-28 19:15:45',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 7,
                'uname' => 'كيلو',
                'crtime' => '2024-09-28 19:15:39',
                'mdtime' => '2024-09-28 19:15:39',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 8,
                'uname' => 'متر',
                'crtime' => '2025-02-26 17:16:07',
                'mdtime' => '2025-02-26 17:16:07',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
        ];

        foreach ($data as $row) {
            DB::table('myunits')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
