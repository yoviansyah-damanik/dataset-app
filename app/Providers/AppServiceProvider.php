<?php

namespace App\Providers;

use App\Helpers\GeneralHelper;
use App\Models\Configuration;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
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
        $init_helpers = [
            new GeneralHelper()
        ];

        Paginator::useBootstrapFive();
    }
}
