<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait HasColumnFiltersField
{
    protected string|null $columnFiltersFieldLabel;

    public function columnFiltersFieldLabel(string|null $label = null): static
    {
        $this->columnFiltersFieldLabel = $label;

        return $this;
    }

    public function getColumnFiltersFieldLabel(): string|null
    {
        return $this->columnFiltersFieldLabel;
    }
}
