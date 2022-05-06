<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait HasFormatField
{
    protected string|null $formatFieldLabel;

    public function formatFieldLabel(string|null $label = null): static
    {
        $this->formatFieldLabel = $label;

        return $this;
    }

    public function getFormatFieldLabel(): string|null
    {
        return $this->formatFieldLabel;
    }
}
