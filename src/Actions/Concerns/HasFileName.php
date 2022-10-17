<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait HasFileName
{
    protected string $fileName;

    protected string|null $fileNamePrefix = null;

    public function fileName(string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFileName(): string
    {
        if (! $this->isFileNamePrefixDisabled() && $this->getFileNamePrefix()) {
            return "{$this->getFileNamePrefix()}-{$this->fileName}";
        }

        return $this->fileName;
    }

    public function fileNamePrefix(string|null $fileNamePrefix): static
    {
        $this->fileNamePrefix = $fileNamePrefix;

        return $this;
    }

    public function getFileNamePrefix(): string|null
    {
        return $this->fileNamePrefix;
    }
}
