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
    
        if (class_exists('\Filament\Support\Facades\FilamentAsset')) {
            \Filament\Support\Facades\FilamentAsset::register([
                \Filament\Support\Assets\Js::make('filament-export-0.3.0', __DIR__.'/../resources/js/filament-export.js'),
                \Filament\Support\Assets\Css::make('filament-export-0.3.0', __DIR__.'/../resources/css/filament-export.css'),
            ]);

            \Filament\Facades\Filament::serving(function () {
                \Filament\Support\Facades\FilamentAsset::renderScripts(['filament-export-0.3.0']);
                \Filament\Support\Facades\FilamentAsset::renderStyles(['filament-export-0.3.0']);
            });
        }
    }
}
