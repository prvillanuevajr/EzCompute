<?php

namespace App\Providers;

use App\Brand;
use App\Category;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::share('categories', Category::all());
        View::share('brands', Brand::all());
        Blade::if('admin', function () {
            return (auth()->check() && auth()->user()->is_admin);
        });
    }
}
