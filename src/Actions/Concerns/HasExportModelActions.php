<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use Filament\Actions\Action;

trait HasExportModelActions
{
    public function getPreviewAction(): array
    {
        $uniqueActionId = $this->getUniqueActionId();

        return ! $this->isPreviewDisabled() ? [
            Action::make('preview')
                ->button()
                ->label(__('filament-export::export_action.preview_action_label'))
                ->color('success')
                ->icon(config('filament-export.preview_icon'))
                ->action("\$dispatch('open-preview-modal-{$uniqueActionId}')")
                ->livewireTarget($this->getLivewireCallMountedActionName()),
        ] : [];
    }

    public function getExportModalActions(): array
    {
        $uniqueActionId = $this->getUniqueActionId();

        $livewireCallActionName = null;

        if (method_exists($this, 'getLivewireSubmitActionName')) {
            $livewireCallActionName = $this->getLivewireSubmitActionName();
        } elseif (method_exists($this, 'getLivewireCallActionName')) {
            $livewireCallActionName = $this->getLivewireCallActionName();
        } else {
            $livewireCallActionName = $this->name;
        }

        return array_merge(
            $this->getPreviewAction(),
            [
                Action::make('submit')
                    ->button()
                    ->label($this->getModalSubmitActionLabel())
                    ->submit($livewireCallActionName)
                    ->color($this->getColor() !== 'secondary' ? $this->getColor() : null)
                    ->icon(config('filament-export.export_icon'))
                    ->livewireTarget($this->getLivewireCallMountedActionName()),
                Action::make('print')
                    ->button()
                    ->label(__('filament-export::export_action.print_action_label'))
                    ->color('gray')
                    ->icon(config('filament-export.print_icon'))
                    ->dispatch("print-table-{$uniqueActionId}")
                    ->livewireTarget($this->getLivewireCallMountedActionName()),
                Action::make('cancel')
                    ->button()
                    ->label(__('filament-export::export_action.cancel_action_label'))
                    ->close()
                    ->color('secondary')
                    ->icon(config('filament-export.cancel_icon'))
                    ->dispatch("close-preview-modal-{$uniqueActionId}")
                    ->livewireTarget($this->getLivewireCallMountedActionName()),
            ]
        );
    }
}
