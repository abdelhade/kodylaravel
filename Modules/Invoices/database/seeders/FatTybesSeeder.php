<?php

namespace Modules\Invoices\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FatTybesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'fname' => 'فاتورة مبيعات',
                'info' => null,
                'crttime' => '2024-01-29 16:39:27',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 2,
                'fname' => 'فاتورة مشنريات',
                'info' => null,
                'crttime' => '2024-01-29 16:41:22',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 3,
                'fname' => 'فاتورة مردود مبيعات',
                'info' => null,
                'crttime' => '2024-03-06 15:25:41',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 4,
                'fname' => 'فاتورة مردود مشتريات',
                'info' => null,
                'crttime' => '2024-03-06 15:26:30',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 5,
                'fname' => 'اذن تسليم بضاعه',
                'info' => null,
                'crttime' => '2024-03-06 15:26:30',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 6,
                'fname' => 'اذن استلام بضاعه',
                'info' => null,
                'crttime' => '2024-03-06 15:26:57',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 7,
                'fname' => 'اذن تسليم بضاعه',
                'info' => null,
                'crttime' => '2024-03-06 15:26:57',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 8,
                'fname' => 'اذن حجز',
                'info' => null,
                'crttime' => '2024-03-06 15:29:32',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 9,
                'fname' => 'امر بيع',
                'info' => null,
                'crttime' => '2024-03-06 15:29:32',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 10,
                'fname' => 'امر شراء',
                'info' => null,
                'crttime' => '2024-03-06 15:29:32',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 11,
                'fname' => 'فاتورة تصنيع حر',
                'info' => null,
                'crttime' => '2024-03-06 15:29:32',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
            [
                'id' => 12,
                'fname' => 'تصنيع نموذجي',
                'info' => null,
                'crttime' => '2024-03-06 15:29:32',
                'isdeleted' => 0,
                'tenant' => 0,
                'branch' => 0,
            ],
        ];

        foreach ($data as $row) {
            DB::table('fat_tybes')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
