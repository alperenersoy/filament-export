<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use Closure;

trait CanHaveExtraColumns
{
    protected array | Closure $withColumns = [];

    public function withColumns(array | Closure $columns): static
    {
        $this->withColumns = $columns;

        return $this;
    }

    public function getWithColumns(): array
    {
        return $this->evaluate($this->withColumns);
    }
}