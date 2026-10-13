<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasPaginator
{
    protected LengthAwarePaginator|Closure|null $paginator = null;

    protected ?LengthAwarePaginator $resolvedPaginator = null;

    public function paginator(LengthAwarePaginator|Closure|null $paginator): static
    {
        if ($paginator) {
            $this->paginator = $paginator;
            $this->resolvedPaginator = null;
        }

        return $this;
    }

    public function getPaginator(): ?LengthAwarePaginator
    {
        if ($this->paginator instanceof Closure) {
            return $this->resolvedPaginator ??= call_user_func($this->paginator);
        }

        return $this->paginator;
    }

    public function hasPaginator(): bool
    {
        return $this->paginator !== null;
    }
}
