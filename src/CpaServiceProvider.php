<?php

namespace A1ex7\Cpa;

use A1ex7\Cpa\Conversion\ConversionService;
use A1ex7\Cpa\Lead\LeadParser;
use A1ex7\Cpa\Lead\LeadService;
use A1ex7\Cpa\Lead\Parser\Chain;
use Illuminate\Support\ServiceProvider;

class CpaServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'a1ex7');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'a1ex7');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/cpa.php', 'cpa');

        // Register the service the package provides.
        $this->app->singleton('cpa', function ($app) {
            return new Cpa;
        });
        $this->app->singleton('cpaLead', LeadService::class);
        $this->app->singleton('cpaConversion', ConversionService::class);
        $this->app->singleton(LeadParser::class, Chain::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['cpa'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/cpa.php' => config_path('cpa.php'),
        ], 'cpa.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/a1ex7'),
        ], 'cpa.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/a1ex7'),
        ], 'cpa.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/a1ex7'),
        ], 'cpa.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
