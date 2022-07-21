<?php

namespace AlperenErsoy\FilamentExport\Concerns;

trait CanHaveExtraViewData
{
    protected array $extraViewData = [];

    public function extraViewData(array $extraViewData): static
    {
        if (count($extraViewData) == 0) {
            return $this;
        }

        $this->extraViewData = $extraViewData;

        return $this;
    }

    public function getExtraViewData(): array
    {
        return $this->extraViewData;
    }
}
