<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use Illuminate\Support\Collection;

trait CanHaveExtraColumns
{
    protected array $withColumns = [];

    public function withColumns(array $columns): static
    {
        $this->withColumns = $columns;

        return $this;
    }

    public function getWithColumns(): Collection
    {
        return collect($this->withColumns);
    }
}