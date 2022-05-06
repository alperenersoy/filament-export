<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait CanHaveAdditionalColumns
{
    protected array $additionalColumns = [];

    public function additionalColumns(array $additionalColumns): static
    {
        if (count($additionalColumns) == 0)
            return $this;

        $this->additionalColumns = $additionalColumns;

        return $this;
    }

    public function getAdditionalColumns(): Collection
    {
        return collect($this->additionalColumns)
            ->map(fn ($value, $key) => \Filament\Tables\Columns\TextColumn::make(Str::snake($key))->label($key)->default($value));
    }
}
