<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait HasData
{
    protected Collection|LengthAwarePaginator $data;

    public function data(Collection|LengthAwarePaginator $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): Collection|LengthAwarePaginator
    {
        return $this->data;
    }
}
