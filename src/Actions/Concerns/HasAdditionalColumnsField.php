<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait HasAdditionalColumnsField
{
    protected string|null $additionalColumnsFieldLabel;

    protected string|null $additionalColumnsTitleFieldLabel;

    protected string|null $additionalColumnsDefaultValueFieldLabel;

    protected string|null $additionalColumnsAddButtonLabel;

    public function additionalColumnsFieldLabel(string|null $label = null): static
    {
        $this->additionalColumnsFieldLabel = $label;

        return $this;
    }

    public function getAdditionalColumnsFieldLabel(): string|null
    {
        return $this->additionalColumnsFieldLabel;
    }

    public function additionalColumnsTitleFieldLabel(string|null $label = null): static
    {
        $this->additionalColumnsTitleFieldLabel = $label;

        return $this;
    }

    public function getAdditionalColumnsTitleFieldLabel(): string|null
    {
        return $this->additionalColumnsTitleFieldLabel;
    }

    public function additionalColumnsDefaultValueFieldLabel(string|null $label = null): static
    {
        $this->additionalColumnsDefaultValueFieldLabel = $label;

        return $this;
    }

    public function getAdditionalColumnsDefaultValueFieldLabel(): string|null
    {
        return $this->additionalColumnsDefaultValueFieldLabel;
    }

    public function additionalColumnsAddButtonLabel(string|null $label = null): static
    {
        $this->additionalColumnsAddButtonLabel = $label;

        return $this;
    }

    public function getAdditionalColumnsAddButtonLabel(): string|null
    {
        return $this->additionalColumnsAddButtonLabel;
    }
}
