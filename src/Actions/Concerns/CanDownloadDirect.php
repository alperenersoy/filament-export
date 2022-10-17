<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

trait CanDownloadDirect
{
    protected bool $shouldDownloadDirect = false;

    public function directDownload(bool $condition = true): static
    {
        $this->shouldDownloadDirect = $condition;

        return $this;
    }

    public function shouldDownloadDirect(): bool
    {
        return $this->shouldDownloadDirect;
    }

    public function fillDefaultData(&$data)
    {
        if (! is_array($data) || count($data) == 0) {
            $data = [
                'file_name' => null,
                'filter_columns' => [],
                'additional_columns' => [],
                'page_orientation' => null,
            ];
        }
    }
}
