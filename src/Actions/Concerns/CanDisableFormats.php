<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use AlperenErsoy\FilamentExport\FilamentExport;

trait CanDisableFormats
{
    protected array $formats = FilamentExport::DEFAULT_FORMATS;

    public function disablePdf(): static
    {
        unset($this->formats['pdf']);

        return $this;
    }

    public function disableXlsx(): static
    {
        unset($this->formats['xlsx']);

        return $this;
    }

    public function disableCsv(): static
    {
        unset($this->formats['csv']);

        return $this;
    }

    public function getFormats(): array
    {
        if (!empty($this->formats)) {
            return $this->formats;
        }

        return FilamentExport::DEFAULT_FORMATS;
    }
}
