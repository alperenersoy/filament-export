<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use Illuminate\Support\Collection;

trait CanFilterColumns
{
    protected array $filteredColumns = [];

    public function filteredColumns(array $columns): static
    {
        if (count($columns) == 0) {
            return $this;
        }

        $this->filteredColumns = $columns;

        return $this;
    }

    public function getFilteredColumns(): Collection
    {
        return collect($this->filteredColumns);
    }
}
