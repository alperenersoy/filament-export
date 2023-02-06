<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait HasRowLoop
{
    protected string|null $rowLoop = null;
    protected bool $isFromZero = false;

    public function rowLoop(string|null $name = null, bool $isFromZero = false): static
    {
        $this->rowLoop = $name;
        $this->isFromZero = $isFromZero;

        return $this;
    }

    public function getRowLoopName(): string|null
    {
        return $this->rowLoop;
    }

    public function getRowIndex(int $index): int
    {
        return $this->isFromZero ? $index : $index + 1;
    }
}
