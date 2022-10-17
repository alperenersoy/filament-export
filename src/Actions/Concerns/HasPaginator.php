<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use Illuminate\Pagination\LengthAwarePaginator;

trait HasPaginator
{
    protected ?LengthAwarePaginator $paginator = null;

    public function paginator(?LengthAwarePaginator $paginator): static
    {
        $this->paginator = $paginator;

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
