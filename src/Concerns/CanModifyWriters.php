<?php

namespace AlperenErsoy\FilamentExport\Concerns;

use Closure;

trait CanModifyWriters
{
    protected ?Closure $modifyExcelWriter = null;

    protected ?Closure $modifyPdfWriter = null;

    public function modifyPdfWriter(?Closure $modifyPdfWriter): static
    {
        $this->modifyPdfWriter = $modifyPdfWriter;

        return $this;
    }

    public function modifyExcelWriter(?Closure $modifyExcelWriter): static
    {
        $this->modifyExcelWriter = $modifyExcelWriter;

        return $this;
    }

    public function getModifyPdfWriter(): ?Closure
    {
        return $this->modifyPdfWriter;
    }

    public function getModifyExcelWriter(): ?Closure
    {
        return $this->modifyExcelWriter;
    }
}
