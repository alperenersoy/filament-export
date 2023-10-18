<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanFormatStates
{
    protected $formatStates = [];

    public function formatStates(array $functions = []): static
    {
        $this->formatStates = $functions;

        return $this;
    }

    public function getFormatStates(): array
    {
        return $this->formatStates;
    }
}
