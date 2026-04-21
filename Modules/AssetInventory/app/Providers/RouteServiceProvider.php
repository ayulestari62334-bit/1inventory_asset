<?php

namespace Modules\AssetInventory\app\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'AssetInventory';

    public function boot(): void
    {
        $this->routes(function () {

            // ✅ ROUTE LARAVEL UTAMA (INI YANG HILANG)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // ✅ ROUTE MODULE
            Route::middleware('web')
                ->group(module_path($this->name, 'routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(module_path($this->name, 'routes/api.php'));
        });
    }
}
