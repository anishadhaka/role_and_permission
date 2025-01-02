<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Module;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // You can register other services here
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Retrieve the menu and module data
        $menuData = Menu::where('id', 5)->first();
        $module = Module::get();
        // Ensure that the menu data is decoded
        if ($menuData) {
            $menuData->json_output = json_decode($menuData->json_output, true);
        }

        // Share the data globally to all views
        View::share('menu_nav', $menuData);
        View::share('module', $module);
    }
}
