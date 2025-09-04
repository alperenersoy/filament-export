<?php

namespace AlperenErsoy\FilamentExport\Tests\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('user.name'),
        ])
        ->recordActions([
            ViewAction::make(),
            EditAction::make(),
        ])
        ->headerActions([
            \AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction::make('export'),
        ])
        ->toolbarActions([
            \AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction::make('export'),
            DeleteBulkAction::make(),
        ]);
    }
}
