<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use Illuminate\Support\Collection;

trait CanDisableTableColumns
{
    protected bool $isTableColumnsDisabled = false;

    public function disableTableColumns(bool $condition = true): static
    {
        $this->isTableColumnsDisabled = $condition;

        return $this;
    }

    public function isTableColumnsDisabled(): bool
    {
        return $this->isTableColumnsDisabled;
    }
}
