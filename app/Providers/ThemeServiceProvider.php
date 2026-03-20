<?php

namespace App\Providers;
  use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cookie;

class ThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    
    

public function boot()
{
    View::composer('*', function ($view) {
        $view->with('theme', 'light');
    });
}
    
}