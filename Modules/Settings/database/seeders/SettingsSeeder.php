<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'company_name' => 'FOCUS HOUSE',
                'company_add' => 'سمنود - برج زايد - الدور الخامس',
                'company_email' => 'abdelhadeeladawy@gmail.com',
                'company_tel' => '010053662038',
                'edit_pass' => '125',
                'lic' => 'd35c99e7485691ea14f829029dc03e69A67b8d2f92148f52cad46e331936922e8',
                'updateline' => '',
                'acc_rent' => 99,
                'startdate' => '2024-01-01',
                'enddate' => '2024-12-31',
                'lang' => 'ar',
                'bodycolor' => '#f0f0f0',
                'showhr' => 1,
                'showclinc' => 1,
                'showatt' => 1,
                'showpayroll' => 1,
                'showrent' => 1,
                'showpay' => 1,
                'showtsk' => 1,
                'def_pos_client' => 155,
                'def_pos_store' => 27,
                'def_pos_employee' => 131,
                'def_pos_fund' => 21,
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
                'logo' => null,
                'show_all_tasks' => null,
            ],
        ];

        foreach ($data as $row) {
            DB::table('settings')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
