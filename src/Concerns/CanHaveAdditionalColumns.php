<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait CanHaveAdditionalColumns
{
    protected array $additionalColumns = [];

    public function additionalColumns(array $additionalColumns): static
    {
        if (count($additionalColumns) == 0) {
            return $this;
        }

        $additionalColumns = collect($additionalColumns)->mapWithKeys(function ($value, $key) {
            $name = $key.'-'.uniqid();

            return [$name => \Filament\Tables\Columns\TextColumn::make(Str::snake($name))->label($key)->default($value)];
        })->toArray();

        $this->additionalColumns = $additionalColumns;

        return $this;
    }

    public function getAdditionalColumns(): Collection
    {
        return collect($this->additionalColumns);
    }
}
