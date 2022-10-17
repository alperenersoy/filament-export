<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use AlperenErsoy\FilamentExport\FilamentExport;

trait HasDefaultPageOrientation
{
    protected string $defaultPageOrientation;

    public function defaultPageOrientation(string $defaultPageOrientation): static
    {
        if (! array_key_exists($defaultPageOrientation, FilamentExport::getPageOrientations())) {
            return $this;
        }

        $this->defaultPageOrientation = $defaultPageOrientation;

        return $this;
    }

    public function getDefaultPageOrientation(): string
    {
        return $this->defaultPageOrientation;
    }
}
