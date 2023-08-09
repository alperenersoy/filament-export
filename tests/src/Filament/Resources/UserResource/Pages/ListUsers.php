<?php

namespace AlperenErsoy\FilamentExport\Tests\Filament\Resources\UserResource\Pages;

use AlperenErsoy\FilamentExport\Tests\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
