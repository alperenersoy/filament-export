<?php

namespace AlperenErsoy\FilamentExport\Components\Concerns;

use Illuminate\Support\Collection;

trait HasRecords
{
    protected Collection $records;

    public function records(Collection $records): static
    {
        $this->records = $records;

        $this->getExport()->data($this->getRecords());

        return $this;
    }

    public function getRecords(): Collection
    {
        return $this->records;
    }
}
