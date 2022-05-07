<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanDisableFileNamePrefix
{
    protected bool $isFileNamePrefixDisabled;

    public function disableFileNamePrefix(bool $condition = true): static
    {
        $this->isFileNamePrefixDisabled = $condition;

        return $this;
    }

    public function isFileNamePrefixDisabled(): bool
    {
        return $this->isFileNamePrefixDisabled;
    }
}
