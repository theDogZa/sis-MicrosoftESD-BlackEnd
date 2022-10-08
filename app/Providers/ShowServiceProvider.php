<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ShowServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', function ($amount) {
            return "<?php
            if($amount < 0) {
                $amount *= -1;
                echo '-'. number_format($amount, 2);
            } else {
                echo  number_format($amount, 2);
            }
            ?>";
        });

        Blade::directive('date', function ($DateString) {
            return "<?php
            echo date('d.m.Y',strtotime($DateString));
            ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
}
