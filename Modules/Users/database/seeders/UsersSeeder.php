<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'uname' => 'admin',
                'password' => Hash::make('198'),
                'crtime' => '2022-12-05 15:01:33',
                'isdeleted' => 0,
                'usertype' => 2,
                'userrole' => 1,
                'img' => '22947314.png',
                'def_client' => null,
                'def_fund' => null,
                'def_store' => null,
                'def_prod' => null,
                'def_emp' => null,
                'tasksindex' => null,
                'tasksadd' => 1,
                'tasksedit' => null,
                'tenant' => 0,
                'branch' => 0,
            ],
        ];

        foreach ($data as $row) {
            DB::table('users')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
