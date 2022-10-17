<?php

use AlperenErsoy\FilamentExport\Tests\Filament\Resources\PostResource;
use AlperenErsoy\FilamentExport\Tests\Filament\Resources\UserResource;
use Illuminate\Support\Facades\Route;

Route::name('filament.resources.')->group(function (): void {
    Route::group([], PostResource::getRoutes());

    Route::group([], UserResource::getRoutes());
});
