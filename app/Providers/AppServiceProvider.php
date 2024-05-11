<?php

namespace App\Providers;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;

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
        
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['pt_BR','en'])
                ->flags([
                    'pt_BR' => asset('flags/brazil.svg'),
                    'en' => asset('flags/usa.svg'),
                ]);
                
        });
    
    }
}
