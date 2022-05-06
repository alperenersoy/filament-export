<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait HasPageOrientationField
{
    protected string|null $pageOrientationFieldLabel;

    public function pageOrientationFieldLabel(string|null $label = null): static
    {
        $this->pageOrientationFieldLabel = $label;

        return $this;
    }

    public function getPageOrientationFieldLabel(): string|null
    {
        return $this->pageOrientationFieldLabel;
    }
}
