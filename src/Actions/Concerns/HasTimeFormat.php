<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait HasTimeFormat
{
    protected string $timeFormat;

    public function timeFormat(string $timeFormat): static
    {
        $this->timeFormat = $timeFormat;

        return $this;
    }

    public function getTimeFormat(): string
    {
        return $this->timeFormat;
    }
}
