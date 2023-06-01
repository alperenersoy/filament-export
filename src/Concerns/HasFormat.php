<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use AlperenErsoy\FilamentExport\FilamentExport;

trait HasFormat
{
    protected string $format;

    public function format(string $format): static
    {
        if (! array_key_exists($format, FilamentExport::DEFAULT_FORMATS)) {
            return $this;
        }

        $this->format = $format;

        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
