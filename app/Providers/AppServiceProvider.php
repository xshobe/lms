<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
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
        require_once app_path() . '/Helpers/MyHelper.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->share('menu_links', Config::get('constants.menu_links'));
        view()->share('loan_status', Config::get('constants.loan_status'));
        view()->share('payment_method', Config::get('constants.payment_method'));
        view()->share('status', Config::get('constants.status'));
        view()->share('salutation_array', Config::get('constants.salutation_array'));
        view()->share('gender_array', Config::get('constants.gender_array'));
        view()->share('loan_scheme', Config::get('constants.loan_scheme'));
        view()->share('currency_symbol', Config::get('constants.currency_symbol'));
        view()->share('deduction_type', Config::get('constants.deduction_type'));

        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
