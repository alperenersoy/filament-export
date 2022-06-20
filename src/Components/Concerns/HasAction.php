<?php

namespace AlperenErsoy\FilamentExport\Components\Concerns;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

trait HasAction
{
    protected FilamentExportBulkAction | FilamentExportHeaderAction $action;

    public function action(FilamentExportBulkAction | FilamentExportHeaderAction $action): static
    {
        $this->action = $action;

        $this->getExport()->fileName($this->getAction()->getFileName());

        $this->getExport()->table($this->getAction()->getTable());

        return $this;
    }

    public function getAction(): FilamentExportBulkAction | FilamentExportHeaderAction
    {
        return $this->action;
    }
}
