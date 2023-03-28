<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait HasRecords
{
    protected Collection $records;

    public function getTableQuery(): Builder
    {
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

        return $query;
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
        return $this
            ->getTableQuery()
            ->get();
    }
}