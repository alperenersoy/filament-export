<?php

namespace AlperenErsoy\FilamentExport\Components;

use AlperenErsoy\FilamentExport\Components\Concerns\HasLivewireTarget;
use Filament\Actions\StaticAction;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Component;
use AlperenErsoy\FilamentExport\FilamentExport;
use Filament\Forms\Components\Concerns\HasName;
use Illuminate\Pagination\LengthAwarePaginator;
use AlperenErsoy\FilamentExport\Components\Concerns\HasUniqueActionId;

class TableView extends Component
{
    use HasName;
    use HasLivewireTarget;
    use HasUniqueActionId;

    protected ?string $statePath = 'table_view';

    protected FilamentExport $export;

    protected bool $shouldRefresh = false;

    protected string $printHTML = '';

    protected function setUp(): void
    {
        parent::setUp();

        $this->view('filament-export::components.table_view');
    }

    public static function make(string $name): static
    {
        $static = app(static::class);
        $static->name($name);
        $static->setUp();

        return $static;
    }

    public function export(FilamentExport $export): static
    {
        $this->export = $export;

        return $this;
    }

    public function getExport(): FilamentExport
    {
        return $this->export;
    }

    public function fileName(string $fileName): static
    {
        $this->getExport()->fileName($fileName);

        return $this;
    }

    public function getFileName(): string
    {
        return $this->getExport()->getFileName();
    }

    public function filteredColumns(array $columns): static
    {
        if (count($columns) == 0) {
            return $this;
        }

        $this->getExport()->filteredColumns($columns);

        return $this;
    }

    public function getFilteredColumns(): Collection
    {
        return $this->getExport()->getFilteredColumns();
    }

    public function additionalColumns(array $additionalColumns): static
    {
        if (count($additionalColumns) == 0) {
            return $this;
        }

        $this->getExport()->additionalColumns($additionalColumns);

        return $this;
    }

    public function getAdditionalColumns(): Collection
    {
        return $this->getExport()->getAdditionalColumns();
    }

    public function extraViewData(array $extraViewData): static
    {
        $this->getExport()->extraViewData($extraViewData);

        return $this;
    }

    public function getExtraViewData(): array
    {
        return $this->getExport()->getExtraViewData();
    }

    public function getAllColumns(): Collection
    {
        return $this->getExport()->getAllColumns();
    }

    public function getRows(): LengthAwarePaginator
    {
        $paginator = $this
            ->getExport()
            ->getPaginator();

        $paginator->getCollection()->transform(function ($row, $key) {
            $data = [];

            foreach ($this->getAllColumns() as $column) {
                if (is_array($row)) {
                    $data[$column->getName()] = data_get($row, $column->getName());

                    continue;
                }

                $data[$column->getName()] = FilamentExport::getColumnState($this->getExport()->getTable(), $column, $row, $key, $this->getExport()->getFormatStates());
            }

            return $data;
        });

        return $paginator;
    }

    public function getExportAction(): StaticAction
    {
        return StaticAction::make('export')
            ->button()
            ->label(__('filament-export::table_view.export_action_label'))
            ->submit('export')
            ->livewireTarget($this->getLivewireTarget())
            ->icon(config('filament-export.export_icon'));
    }

    public function getPrintAction(): StaticAction
    {
        $uniqueActionId = $this->getUniqueActionId();

        return StaticAction::make('print')
            ->button()
            ->label(__('filament-export::table_view.print_action_label'))
            ->action("\$dispatch('print-table-$uniqueActionId')")
            ->color('gray')
            ->livewireTarget($this->getLivewireTarget())
            ->icon(config('filament-export.print_icon'));
    }

    public function getCancelAction(): StaticAction
    {
        return StaticAction::make('cancel')
            ->button()
            ->label(__('filament-export::export_action.cancel_action_label'))
            ->close()
            ->color('secondary')
            ->icon(config('filament-export.cancel_icon'));
    }

    public function getFooterActions(): array
    {
        return [
            $this->getExportAction(),
            $this->getPrintAction(),
            $this->getCancelAction(),
        ];
    }

    public function getPreviewModalHeading(): string
    {
        return __('filament-export::table_view.preview_modal_heading');
    }

    public function data()
    {
        return array_merge(
            parent::data(),
            $this->getExport()->getExtraViewData()
        );
    }

    public function refresh(bool $condition): static
    {
        $this->shouldRefresh = $condition;

        return $this;
    }

    public function shouldRefresh(): bool
    {
        return $this->shouldRefresh;
    }

    public function printHTML(string $printHTML): static
    {
        $this->printHTML = $printHTML;

        return $this;
    }

    public function getPrintHTML(): string
    {
        return htmlentities($this->printHTML);
    }
}
