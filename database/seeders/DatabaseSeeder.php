<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Commented out because users table uses 'uname' instead of 'name' and 'email'
        // Use Modules\Users\Database\Seeders\UsersSeeder instead
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed all module seeders
        $this->call([
            // Users
            \Modules\Users\Database\Seeders\UsersSeeder::class,
            
            // Settings
            \Modules\Settings\Database\Seeders\SettingsSeeder::class,
            
            // Visits
            \Modules\Visits\Database\Seeders\ChancesTybesSeeder::class,
            
            // Accounting
            \Modules\Accounting\Database\Seeders\AccountsSeeder::class,
            \Modules\Accounting\Database\Seeders\CostCentersSeeder::class,
            \Modules\Accounting\Database\Seeders\JournalTybesSeeder::class,
            
            // Invoices
            \Modules\Invoices\Database\Seeders\FatTybesSeeder::class,
            
            // Attendance
            \Modules\Attendance\Database\Seeders\FptybesSeeder::class,
            
            // Kody2
            \Modules\Kody2\Database\Seeders\KbisSeeder::class,
            
            // Inventory
            \Modules\Inventory\Database\Seeders\MyunitsSeeder::class,
            \Modules\Inventory\Database\Seeders\PriceListsSeeder::class,
            
            // Production
            \Modules\Production\Database\Seeders\ProTybesSeeder::class,
        ]);
    }
}
