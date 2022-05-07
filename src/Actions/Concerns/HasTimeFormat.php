<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use Carbon\Carbon;

trait HasTimeFormat
{
    protected string $timeFormat;

    public function timeFormat(string $timeFormat): static
    {
        $this->timeFormat = $timeFormat;

        $this->fileName(Carbon::now()->translatedFormat($this->getTimeFormat()));

        return $this;
    }

    public function getTimeFormat(): string
    {
        return $this->timeFormat;
    }
}
