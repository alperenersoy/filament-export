<?php

namespace AlperenErsoy\FilamentExport\Tests\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use AlperenErsoy\FilamentExport\Tests\Filament\Resources\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
