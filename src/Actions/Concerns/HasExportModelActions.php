<?php

namespace AlperenErsoy\FilamentExport\Actions\Concerns;

use Filament\Tables\Actions\Modal\Actions\ButtonAction;

trait HasExportModelActions
{
    public function getPreviewAction(): array
    {
        return !$this->isPreviewDisabled() ? [
            ButtonAction::make('preview')
                ->label(__('filament-export::export_action.preview_action_label'))
                ->color('success')
                ->icon(config('filament-export.preview_icon'))
                ->action('$emit("open-preview-modal")')
        ] : [];
    }

    public function getExportModalActions(): array
    {
        return array_merge(
            $this->getPreviewAction(),
            [
                ButtonAction::make('submit')
                    ->label($this->getModalButtonLabel())
                    ->submit($this->getLivewireSubmitActionName())
                    ->color($this->getColor() !== 'secondary' ? $this->getColor() : null)
                    ->icon(config('filament-export.export_icon')),
                ButtonAction::make('print')
                    ->label(__('filament-export::export_action.print_action_label'))
                    ->color('gray')
                    ->icon(config('filament-export.print_icon'))
                    ->action('$emit("print-table")'),
                ButtonAction::make('cancel')
                    ->label(__('tables::table.actions.modal.buttons.cancel.label'))
                    ->cancel()
                    ->color('secondary')
                    ->icon(config('filament-export.cancel_icon'))
                    ->action('$emit("close-preview-modal")'),
            ]
        );
    }
}
