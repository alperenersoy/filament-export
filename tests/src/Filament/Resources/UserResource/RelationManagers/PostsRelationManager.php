<?php

namespace AlperenErsoy\FilamentExport\Tests\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('user.name'),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])
        ->headerActions([
            \AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction::make('export'),
        ])
        ->bulkActions([
            \AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction::make('export'),
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }
}
