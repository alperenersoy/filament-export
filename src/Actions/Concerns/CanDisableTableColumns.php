<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanDisableTableColumns
{
    protected bool $isTableColumnsDisabled = false;

    public function disableTableColumns(bool $condition = false): static
    {
        $this->isTableColumnsDisabled = $condition;

        return $this;
    }

    public function isTableColumnsDisabled(): bool
    {
        return $this->isTableColumnsDisabled;
    }
}
