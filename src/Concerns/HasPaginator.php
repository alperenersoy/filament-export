<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use Illuminate\Pagination\LengthAwarePaginator;

trait HasPaginator
{
    protected ?LengthAwarePaginator $paginator = null;

    public function paginator(?LengthAwarePaginator $paginator): static
    {
        if ($paginator) {
            $this->paginator = $paginator;
        }

        return $this;
    }

    public function getPaginator(): ?LengthAwarePaginator
    {
        return $this->paginator;
    }

    public function hasPaginator(): bool
    {
        return $this->paginator !== null;
    }
}
