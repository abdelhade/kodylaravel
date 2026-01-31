<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'cname' => 'المركز الافتراضي',
                'info' => null,
                'crtime' => '2024-01-19 01:17:02',
                'mdtime' => '2024-01-19 01:17:02',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
        ];

        foreach ($data as $row) {
            DB::table('cost_centers')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
