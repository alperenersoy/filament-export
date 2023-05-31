<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use AlperenErsoy\FilamentExport\FilamentExport;

trait HasFormatOptions
{
    protected array $formatOptions = [];

    public function formatOptions(array $formatOptions): static
    {
        $options = [];

        foreach($formatOptions as $fo) {

          if (! array_key_exists($fo, FilamentExport::FORMATS)) {
              continue;
          }

          $options[$fo] = \strtoupper($fo);
        }

        $this->formatOptions = $options;

        return $this;
    }

    public function getFormatOptions(): array
    {
        if (blank($this->formatOptions)) {
            return FilamentExport::FORMATS;
        }

        return $this->formatOptions;
    }
}
