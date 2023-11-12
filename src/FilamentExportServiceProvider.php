<?php

namespace AlperenErsoy\FilamentExport;

use Closure;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentExportServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-export';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasConfigFile()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-export.php', 'filament-export');

        FilamentAsset::register([
            \Filament\Support\Assets\Js::make('filament-export-0.3.0', __DIR__.'/../resources/js/filament-export.js'),
            \Filament\Support\Assets\Css::make('filament-export-0.3.0', __DIR__.'/../resources/css/filament-export.css'),
        ], 'filament-export');
    }
}
