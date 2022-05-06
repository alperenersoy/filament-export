# Filament Export
Customizable export and print functionality for Filament Admin Panel.

This package provides a bulk action and header action to export your filament tables easily.

## Requirements
- PHP 8
- [Filament 2.0](https://github.com/laravel-filament/filament)

### Dependencies
- [maatwebsite/excel](https://github.com/SpartnerNL/Laravel-Excel)
- [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)

## Installation

```bash
composer require alperenersoy/filament-export
```

## Using

### Simple Usage

#### Bulk Action

You can export selected rows with the bulk action.

```php
$table->pushBulkActions([
    FilamentExportBulkAction::make('export')
]);
```

#### Header Action

You can filter, search and export your table with the header action.

```php
$table->pushHeaderActions([
    FilamentExportHeaderAction::make('export')
]);
```

### Full Usage

Both actions provide functions for configuration.

```php
FilamentExportBulkAction::make('export')
    ->fileName('My File') // Default file name
    ->timeFormat('m y d') // Default time format for naming exports
    ->defaultFormat('pdf') // xlsx, csv or pdf
    ->defaultPageOrientation('landscape') // Page orientation for pdf files. portrait or landscape
    ->disableAdditionalColumns() // Disable additional columns input
    ->disableColumnFilters() // Disable column filters input
    ->disableFileName() // Disable file name input
    ->disablePreview() // Disable export preview
    ->fileNameFieldLabel('File Name') // Label for file name input
    ->formatFieldLabel('Format') // Label for format input
    ->pageOrientationFieldLabel('Page Orientation') // Label for page orientation input
    ->columnFiltersFieldLabel('Column Filters') // Label for column filters input
    ->additionalColumnsFieldLabel('Additional Columns') // Label for additional columns input
    ->additionalColumnsTitleFieldLabel('Title') // Label for additional columns' title input 
    ->additionalColumnsDefaultValueFieldLabel('Default Value') // Label for additional columns' default value input 
    ->additionalColumnsAddButtonLabel('Add Column') // Label for additional columns' add button 
```
You can also use default bulk action and header action functions to customize actions.

## Configuration

Publish configuration

```bash
php artisan vendor:publish --provider="AlperenErsoy\FilamentExport\FilamentExportServiceProvider" --tag="config"
```

You can configure these settings:

```php
return [
    'default_format' => 'xlsx',
    'time_format' => 'M_d_Y-H_i',
    'default_page_orientation' => 'portrait',
    'disable_additional_columns' => false,
    'disable_column_filters' => false,
    'disable_file_name' => false,
    'disable_preview' => false,
    'action_icon' => 'heroicon-o-document-download',
    'preview_icon' => 'heroicon-o-eye',
    'export_icon' => 'heroicon-o-download',
    'print_icon' => 'heroicon-o-printer',
    'cancel_icon' => 'heroicon-o-x-circle'
];
```
