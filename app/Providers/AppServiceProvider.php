<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\CartComposer;
use App\Http\ViewComposers\CategoryComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register view composer for cart data
        View::composer(['layouts.header', 'layouts.app'], CartComposer::class);

        // Register view composer for category data
        View::composer(['layouts.header', 'layouts.app'], CategoryComposer::class);
    }
}
