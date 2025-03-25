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

        foreach ($livewire->getTable()->getFilters() as $filter) {
            $filter->applyToBaseQuery(
                $query,
                $livewire->getTableFilterState($filter->getName()) ?? [],
            );
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

        $this->applyGroupingToTableQuery($query);

        $this->applySortingToTableQuery($query);

        return $query;
    }

    protected function applySortingToTableQuery(Builder $query): Builder
    {
        $livewire = $this->getLivewire();

        if ($livewire->getTable()->isGroupsOnly()) {
            return $query;
        }

        if ($livewire->isTableReordering()) {
            return $query->orderBy($livewire->getTable()->getReorderColumn());
        }

        if (!$livewire->tableSortColumn) {
            return $this->applyDefaultSortingToTableQuery($query);
        }

        $column = $livewire->getTable()->getSortableVisibleColumn($livewire->tableSortColumn);

        if (!$column) {
            return $this->applyDefaultSortingToTableQuery($query);
        }

        $sortDirection = $livewire->tableSortDirection === 'desc' ? 'desc' : 'asc';

        $column->applySort($query, $sortDirection);

        return $query;
    }

    protected function applyDefaultSortingToTableQuery(Builder $query): Builder
    {
        $livewire = $this->getLivewire();

        $sortDirection = ($livewire->getTable()->getDefaultSortDirection() ?? $livewire->tableSortDirection) === 'desc' ? 'desc' : 'asc';
        $defaultSort = $livewire->getTable()->getDefaultSort($query, $sortDirection);

        if (
            is_string($defaultSort) &&
            ($sortColumn = $livewire->getTable()->getSortableVisibleColumn($defaultSort))
        ) {
            $sortColumn->applySort($query, $sortDirection);

            return $query;
        }

        if (is_string($defaultSort)) {
            return $query->orderBy($defaultSort, $sortDirection);
        }

        if ($defaultSort instanceof Builder) {
            return $defaultSort;
        }

        if (filled($query->toBase()->orders)) {
            return $query;
        }

        return $query->orderBy($query->getModel()->getQualifiedKeyName());
    }

    protected function applyGroupingToTableQuery(Builder $query): Builder
    {
        $livewire = $this->getLivewire();

        $group = $livewire->getTableGrouping();

        if (!$group) {
            return $query;
        }

        $group->applyEagerLoading($query);

        $group->orderQuery($query, $livewire->getTableGroupingDirection() ?? 'asc');

        return $query;
    }

    public function getRecords(): Collection
    {
        return $this
            ->getTableQuery()
            ->get();
    }
}
