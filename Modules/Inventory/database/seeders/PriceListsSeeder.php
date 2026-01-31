<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'pname' => 'سعر 1',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 2,
                'pname' => 'سعر 2',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
        ];

        foreach ($data as $row) {
            DB::table('price_lists')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
