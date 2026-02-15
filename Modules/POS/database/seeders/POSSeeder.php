<?php

namespace Modules\POS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class POSSeeder extends Seeder
{
    public function run(): void
    {
        // إضافة طاولات تجريبية
        $tables = [];
        for ($i = 1; $i <= 12; $i++) {
            $tables[] = [
                'tname' => 'طاولة ' . $i,
                'table_case' => 0,
                'crtime' => now(),
                'mdtime' => now(),
                'isdeleted' => 0,
                'branch' => 'main',
                'tatnet' => 0,
            ];
        }

        DB::table('tables')->insert($tables);

        echo "تم إضافة 12 طاولة تجريبية بنجاح\n";
    }
}
