<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use Filament\Tables\Actions\Modal\Actions\Action;

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
                ->action("\$emit('open-preview-modal-{$uniqueActionId}')"),
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
        }

        return array_merge(
            $this->getPreviewAction(),
            [
                Action::make('submit')
                    ->button()
                    ->label($this->getModalButtonLabel())
                    ->submit($livewireCallActionName)
                    ->color($this->getColor() !== 'secondary' ? $this->getColor() : null)
                    ->icon(config('filament-export.export_icon')),
                Action::make('print')
                    ->button()
                    ->label(__('filament-export::export_action.print_action_label'))
                    ->color('gray')
                    ->icon(config('filament-export.print_icon'))
                    ->action("\$emit('print-table-{$uniqueActionId}')"),
                Action::make('cancel')
                    ->button()
                    ->label(__('filament-export::export_action.cancel_action_label'))
                    ->cancel()
                    ->color('secondary')
                    ->icon(config('filament-export.cancel_icon'))
                    ->action("\$emit('close-preview-modal-{$uniqueActionId}')"),
            ]
        );
    }
}
