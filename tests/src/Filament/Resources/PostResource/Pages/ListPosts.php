<?php

namespace AlperenErsoy\FilamentExport\Tests\Filament\Resources\PostResource\Pages;

use AlperenErsoy\FilamentExport\Tests\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
