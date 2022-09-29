<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait HasRecordLimit
{
    protected int|null $recordLimit = null;

    public function recordLimit(int $limit): static
    {
        $this->recordLimit = $limit;

        return $this;
    }

    public function getRecordLimit(): int|null
    {
        return $this->recordLimit;
    }
}
