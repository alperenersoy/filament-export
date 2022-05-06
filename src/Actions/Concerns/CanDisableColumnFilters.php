<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanDisableColumnFilters
{
    protected bool $isColumnFiltersDisabled;

    public function disableColumnFilters(bool $condition = true): static
    {
        $this->isColumnFiltersDisabled = $condition;

        return $this;
    }

    public function isColumnFiltersDisabled(): bool
    {
        return $this->isColumnFiltersDisabled;
    }
}
