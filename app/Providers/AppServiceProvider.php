<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{

  public function boot(): void
{
    Paginator::useTailwind();
}

    public function register()
    {
        //
    }
}