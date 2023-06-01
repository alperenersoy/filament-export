<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanDisableFormats
{
    protected ?array $formats = null;

    protected bool $disablePdf = false;

    protected bool $disableXlsx = false;

    protected bool $disableCsv = false;

    public function disablePdf(): static
    {
        $this->disablePdf = true;

        return $this;
    }

    public function disableXlsx(): static
    {
        $this->disableXlsx = true;

        return $this;
    }

    public function disableCsv(): static
    {
        $this->disableeCsv = true;

        return $this;
    }

    public function getFormats(): array
    {
        if ($this->formats !== null) {
            return $this->formats;
        }

        $this->formats = [];

        if (! $this->disablePdf) {
            $this->formats['pdf'] = 'PDF';
        }

        if (! $this->disableXlsx) {
            $this->formats['xlsx'] = 'XLSX';
        }

        if (! $this->disableCsv) {
            $this->formats['csv'] = 'CSV';
        }

        return $this->formats;
    }
}
