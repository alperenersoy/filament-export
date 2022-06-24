<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait HasFilterColumnsField
{
    protected string|null $filterColumnsFieldLabel;

    public function filterColumnsFieldLabel(string|null $label = null): static
    {
        $this->filterColumnsFieldLabel = $label;

        return $this;
    }

    public function getFilterColumnsFieldLabel(): string|null
    {
        return $this->filterColumnsFieldLabel;
    }
}
