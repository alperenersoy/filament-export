<?php

namespace AlperenErsoy\FilamentExport;

use Illuminate\Support\ServiceProvider;

class FilamentExportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-export.php', 'filament-export');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-export');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-export');

        $this->publishes([
            __DIR__.'/../config/filament-export.php' => config_path('filament-export.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/filament-export'),
        ], 'views');
    
        if (class_exists('\Filament\Facades\Filament')) {
            \Filament\Facades\Filament::serving(function () {
                \Filament\Facades\Filament::registerScripts([
                    'filament-export-0.3.0' => __DIR__.'/../resources/js/filament-export.js',
                ]);
                \Filament\Facades\Filament::registerStyles([
                    'filament-export-0.3.0' => __DIR__.'/../resources/css/filament-export.css',
                ]);
            });
        }
    }
}
