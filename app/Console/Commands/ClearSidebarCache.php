<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\SidebarHelper;

class ClearSidebarCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sidebar:clear-cache {--all : Clear all sidebar cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear sidebar related cache (settings, user data)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('all')) {
            SidebarHelper::clearAllCache();
            $this->info('All sidebar cache cleared successfully!');
        } else {
            $this->info('Clearing sidebar cache...');
            SidebarHelper::clearSettingsCache();
            $this->info('Settings cache cleared.');
            SidebarHelper::clearUserDataCache();
            $this->info('User data cache cleared.');
            $this->info('Sidebar cache cleared successfully!');
        }
        
        return Command::SUCCESS;
    }
}
