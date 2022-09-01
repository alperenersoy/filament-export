<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanShowHiddenColumns
{
    protected bool $shouldShowHiddenColumns = false;

    public function withHiddenColumns(bool $condition = true): static
    {
        $this->shouldShowHiddenColumns = $condition;

        return $this;
    }

    public function shouldShowHiddenColumns(): bool
    {
        return $this->shouldShowHiddenColumns;
    }
}
