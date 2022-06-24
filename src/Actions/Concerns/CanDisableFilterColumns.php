<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanDisableFilterColumns
{
    protected bool $isFilterColumnsDisabled;

    public function disableFilterColumns(bool $condition = true): static
    {
        $this->isFilterColumnsDisabled = $condition;

        return $this;
    }

    public function isFilterColumnsDisabled(): bool
    {
        return $this->isFilterColumnsDisabled;
    }
}
