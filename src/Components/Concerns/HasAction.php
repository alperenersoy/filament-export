<?php

namespace AlperenErsoy\FilamentExport\Components\Concerns;

use AlperenErsoy\FilamentExport\Actions\FilamentExportAction;

trait HasAction
{
    protected FilamentExportAction $action;

    public function action(FilamentExportAction $action): static
    {
        $this->action = $action;

        $this->getExport()->fileName($this->getAction()->getFileName());

        $this->getExport()->table($this->getAction()->getTable());

        return $this;
    }

    public function getAction(): FilamentExportAction
    {
        return $this->action;
    }
}
