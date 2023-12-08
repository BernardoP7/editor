<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AjaxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Load the helpers in app/service/functions.php
        if (file_exists($file = base_path('app/Services/ajax.php')))
        {
            require $file;
        }

    }
}
