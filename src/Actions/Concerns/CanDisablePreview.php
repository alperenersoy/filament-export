<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanDisablePreview
{
    protected bool $isPreviewDisabled;

    public function disablePreview(bool $condition = true): static
    {
        $this->isPreviewDisabled = $condition;

        $this->modalActions($this->getExportModalActions());

        return $this;
    }

    public function isPreviewDisabled(): bool
    {
        return $this->isPreviewDisabled;
    }
}
