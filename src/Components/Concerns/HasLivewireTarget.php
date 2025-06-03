<?php

namespace AlperenErsoy\FilamentExport\Components\Concerns;

trait HasLivewireTarget
{
    protected string $livewireTarget = '';

    public function livewireTarget(string $livewireTarget): static
    {
        $this->livewireTarget = $livewireTarget;

        return $this;
    }

    public function getLivewireTarget(): string
    {
        return $this->livewireTarget;
    }
}
