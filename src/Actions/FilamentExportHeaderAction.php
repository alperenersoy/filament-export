<?php

namespace AlperenErsoy\FilamentExport\Actions;

use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisableAdditionalColumns;
use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisableColumnFilters;
use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisableFileName;
use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisableFileNamePrefix;
use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisablePreview;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasAdditionalColumnsField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasColumnFiltersField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasDefaultFormat;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasDefaultPageOrientation;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasExportModelActions;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasFileName;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasFileNameField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasFormatField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasPageOrientationField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasTimeFormat;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasUniqueActionId;
use AlperenErsoy\FilamentExport\FilamentExport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FilamentExportHeaderAction extends \Filament\Tables\Actions\Action
{
    use CanDisableAdditionalColumns;
    use CanDisableColumnFilters;
    use CanDisableFileName;
    use CanDisableFileNamePrefix;
    use CanDisablePreview;
    use HasAdditionalColumnsField;
    use HasColumnFiltersField;
    use HasDefaultFormat;
    use HasDefaultPageOrientation;
    use HasExportModelActions;
    use HasFileName;
    use HasFileNameField;
    use HasFormatField;
    use HasPageOrientationField;
    use HasTimeFormat;
    use HasUniqueActionId;

    protected Collection $records;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uniqueActionId('header-action');

        FilamentExport::setUpFilamentExportAction($this);

        $this->form(static function ($action): array {
            $records = $action->getTableRecords();

            $action->records = $records;

            return array_merge(
                FilamentExport::getFormComponents($action, $records),
                [
                    \Filament\Forms\Components\Hidden::make('records')
                        ->default($records)
                ]
            );
        })
            ->action(static function ($action, $data) {
                $records = $action->getRecords();

                return FilamentExport::callDownload($action, $records, $data);
            });
    }

    public function getTableRecords(): Collection
    {
        $livewire = $this->getLivewire();

        $model = $this->getTable()->getModel();
        $query = $model::query();

        $filterData = $livewire->tableFilters;

        if (isset($livewire->ownerRecord)) {
            $query->whereBelongsTo($livewire->ownerRecord);
        }

        $livewire->cacheTableFilters();

        $query->where(function (Builder $query) use ($filterData, $livewire) {
            foreach ($livewire->getCachedTableFilters() as $filter) {
                $filter->apply(
                    $query,
                    $filterData[$filter->getName()] ?? [],
                );
            }
        });

        $searchQuery = $livewire->tableSearchQuery;

        if ($searchQuery !== '') {
            foreach (explode(' ', $searchQuery) as $searchQueryWord) {
                $query->where(function (Builder $query) use ($searchQueryWord, $livewire) {
                    $isFirst = true;

                    foreach ($livewire->getCachedTableColumns() as $column) {
                        $column->applySearchConstraint($query, $searchQueryWord, $isFirst);
                    }
                });
            }
        }

        foreach ($livewire->getCachedTableColumns() as $column) {
            $column->applyEagerLoading($query);
            $column->applyRelationshipAggregates($query);
        }

        $this->applySortingToTableQuery($query);

        return $query->get();
    }

    protected function applySortingToTableQuery(Builder $query): Builder
    {
        $livewire = $this->getLivewire();

        $columnName = $livewire->tableSortColumn;

        if (!$columnName) {
            return $query;
        }

        $direction = $livewire->tableSortDirection === 'desc' ? 'desc' : 'asc';

        if ($column = $livewire->getCachedTableColumns()[$columnName]) {
            $column->applySort($query, $direction);

            return $query;
        }

        if ($columnName === $livewire->getDefaultSortColumn()) {
            return $query->orderBy($columnName, $direction);
        }

        return $query;
    }

    public function getRecords(): Collection
    {
        return $this->records;
    }
}
