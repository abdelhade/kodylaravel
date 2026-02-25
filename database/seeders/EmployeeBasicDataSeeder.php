<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeBasicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add basic jobs
        $jobs = [
            ['name' => 'موظف مبيعات', 'info' => 'موظف مبيعات', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'محاسب', 'info' => 'محاسب', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'مدير', 'info' => 'مدير', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'موظف استقبال', 'info' => 'موظف استقبال', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'فني', 'info' => 'فني', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($jobs as $job) {
            DB::table('jops')->insertOrIgnore($job);
        }

        // Add basic departments
        $departments = [
            ['name' => 'المبيعات', 'info' => 'قسم المبيعات', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'المحاسبة', 'info' => 'قسم المحاسبة', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'الإدارة', 'info' => 'قسم الإدارة', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'الدعم الفني', 'info' => 'قسم الدعم الفني', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insertOrIgnore($department);
        }

        // Add basic shifts
        $shifts = [
            ['name' => 'الصباحي', 'info' => 'الشيفت الصباحي', 'shiftstart' => '08:00:00', 'shiftend' => '16:00:00', 'hours' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'المسائي', 'info' => 'الشيفت المسائي', 'shiftstart' => '16:00:00', 'shiftend' => '00:00:00', 'hours' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'الليلي', 'info' => 'الشيفت الليلي', 'shiftstart' => '00:00:00', 'shiftend' => '08:00:00', 'hours' => 8, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($shifts as $shift) {
            DB::table('shifts')->insertOrIgnore($shift);
        }

        // Add basic job types
        $jobTypes = [
            ['name' => 'دوام كامل', 'info' => 'دوام كامل', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'دوام جزئي', 'info' => 'دوام جزئي', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'مؤقت', 'info' => 'عمل مؤقت', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($jobTypes as $jobType) {
            DB::table('joptybes')->insertOrIgnore($jobType);
        }

        // Add basic job levels
        $jobLevels = [
            ['name' => 'مبتدئ', 'info' => 'مستوى مبتدئ', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'متوسط', 'info' => 'مستوى متوسط', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'متقدم', 'info' => 'مستوى متقدم', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'خبير', 'info' => 'مستوى خبير', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($jobLevels as $jobLevel) {
            DB::table('joplevels')->insertOrIgnore($jobLevel);
        }

        // Add basic towns
        $towns = [
            ['name' => 'القاهرة', 'info' => 'القاهرة', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'الإسكندرية', 'info' => 'الإسكندرية', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'الجيزة', 'info' => 'الجيزة', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($towns as $town) {
            DB::table('towns')->insertOrIgnore($town);
        }

        echo "تم إضافة البيانات الأساسية بنجاح!\n";
        echo "الوظائف: " . DB::table('jops')->count() . "\n";
        echo "الأقسام: " . DB::table('departments')->count() . "\n";
        echo "الشيفتات: " . DB::table('shifts')->count() . "\n";
        echo "أنواع الوظائف: " . DB::table('joptybes')->count() . "\n";
        echo "مستويات الوظائف: " . DB::table('joplevels')->count() . "\n";
        echo "المدن: " . DB::table('towns')->count() . "\n";
    }
}
