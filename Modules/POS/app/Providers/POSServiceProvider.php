<?php

namespace Modules\POS\Providers;

use Illuminate\Support\ServiceProvider;

class POSServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'pos');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
