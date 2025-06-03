<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use Filament\Actions\StaticAction;

trait HasExportModelActions
{
    public function getPreviewAction(): array
    {
        $uniqueActionId = $this->getUniqueActionId();

        return ! $this->isPreviewDisabled() ? [
            StaticAction::make('preview')
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
                StaticAction::make('submit')
                    ->button()
                    ->label($this->getModalSubmitActionLabel())
                    ->submit($livewireCallActionName)
                    ->color($this->getColor() !== 'secondary' ? $this->getColor() : null)
                    ->icon(config('filament-export.export_icon'))
                    ->livewireTarget($this->getLivewireCallMountedActionName()),
                StaticAction::make('print')
                    ->button()
                    ->label(__('filament-export::export_action.print_action_label'))
                    ->color('gray')
                    ->icon(config('filament-export.print_icon'))
                    ->action("\$dispatch('print-table-{$uniqueActionId}')")
                    ->livewireTarget($this->getLivewireCallMountedActionName()),
                StaticAction::make('cancel')
                    ->button()
                    ->label(__('filament-export::export_action.cancel_action_label'))
                    ->close()
                    ->color('secondary')
                    ->icon(config('filament-export.cancel_icon'))
                    ->action("\$dispatch('close-preview-modal-{$uniqueActionId}')")
                    ->livewireTarget($this->getLivewireCallMountedActionName()),
            ]
        );
    }
}
