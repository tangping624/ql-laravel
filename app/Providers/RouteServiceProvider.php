<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use App\Models\Admin;
use App\Models\Product;
use App\Models\Merchant;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('admin', function ($value) {
            return Route::currentRouteName() == 'admin.admin.enable' ?
                Admin::withoutGlobalScope('status')->find($value) :
                Admin::find($value);
        });

        Route::bind('merchant', function ($value) {
            // 允许操作软删除对象的路由
            $withTrashedRouteName = [
                'admin.merchant.store',
            ];
            if (in_array(Route::currentRouteName(), $withTrashedRouteName)) {
                return Merchant::withTrashed()->find($value);
            } else {
                return Merchant::find($value);
            }
        });

        Route::bind('product', function ($value) {
            $withTrashedRouteName = [
                'admin.product.store',
            ];
            if (in_array(Route::currentRouteName(), $withTrashedRouteName)) {
                return Product::withTrashed()->find($value);
            } else {
                return Product::find($value);
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapAdminRoutes();

        $this->mapWebRoutes();
        
        $this->mapHomeRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware('web')
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/admin.php'));
    }
    
    protected function mapHomeRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace . '\Home')
        ->group(base_path('routes/home.php'));
    }
}
