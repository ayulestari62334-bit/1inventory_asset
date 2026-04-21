<?php

namespace Modules\AssetInventory\app\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\AssetInventory\app\Providers\RouteServiceProvider;

class AssetInventoryServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'AssetInventory';

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(
            module_path($this->moduleName, 'resources/views'),
            'assetinventory'
        );
    }
}
