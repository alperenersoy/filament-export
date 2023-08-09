<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait HasRecords
{
    protected Collection $records;

    public function getTableQuery(): Builder
    {
        /** @var \Filament\Resources\Pages\ListRecords $livewire */
        $livewire = $this->getLivewire();

        $model = $this->getTable()->getModel();
        $query = $model::query();

        if (method_exists($livewire, 'getResource')) {
            $query = $livewire::getResource()::getEloquentQuery();
        }

        $reflection = new \ReflectionMethod($livewire, 'getTableQuery');

        if ($reflection->isPublic()) {
            $query = $livewire->getTableQuery();
        }

        $filterData = $livewire->tableFilters;

        if (isset($livewire->ownerRecord)) {
            $query->whereBelongsTo($livewire->ownerRecord);
        }

        $query->where(function (Builder $query) use ($filterData, $livewire) {
            foreach ($livewire->getTable()->getFilters() ?? [] as $filter) {
                $filter->apply(
                    $query,
                    $filterData[$filter->getName()] ?? [],
                );
            }
        });

        $searchQuery = $livewire->getTableSearch();

        if ($searchQuery !== '') {
            foreach (explode(' ', $searchQuery) as $searchQueryWord) {
                $query->where(function (Builder $query) use ($searchQueryWord, $livewire) {
                    $isFirst = true;

                    foreach ($livewire->getTable()->getColumns() as $column) {
                        if ($column->isSearchable()) {
                            $column->applySearchConstraint($query, $searchQueryWord, $isFirst);
                        }
                    }
                });
            }
        }

        foreach ($livewire->getTable()->getColumns() as $column) {
            $column->applyEagerLoading($query);
            $column->applyRelationshipAggregates($query);
        }

        $this->applySortingToTableQuery($query);

        return $query;
    }

    protected function applySortingToTableQuery(Builder $query): Builder
    {
        /** @var \Filament\Resources\Pages\ListRecords $livewire */
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
        return $this
            ->getTableQuery()
            ->get();
    }
}
