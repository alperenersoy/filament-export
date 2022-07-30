<?php

namespace AlperenErsoy\FilamentExport\Tests\Filament\Resources\PostResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use AlperenErsoy\FilamentExport\Tests\Filament\Resources\PostResource;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
