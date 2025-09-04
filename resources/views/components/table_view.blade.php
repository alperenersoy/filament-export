@php
    $uniqueActionId = $getUniqueActionId();

    $statePath = $getStatePath();

    $shouldRefresh = $shouldRefresh();

    $data = $this->getMountedActionSchema()->getState();

    $tableViewName = \AlperenErsoy\FilamentExport\FilamentExport::TABLE_VIEW_NAME;

    $shouldPrint = is_array($data) && array_key_exists($tableViewName, $data) && $data[$tableViewName] == 'print-' . $uniqueActionId;

    $printContent = $shouldPrint ? $getPrintHTML() : '';
@endphp

<input id="{{ $statePath }}" type="hidden" {{ $applyStateBindingModifiers('wire:model') }}="{{ $statePath }}">

<x-filament::modal id="preview-modal" width="7xl" display-classes="block" :dark-mode="config('filament.dark_mode')"
    x-init="$wire.$on('open-preview-modal-{{ $uniqueActionId }}', function() {
        $set('{{ $tableViewName }}', '{{ uniqid() }}');
        isOpen = true;
    });
    
    $wire.$on('close-preview-modal-{{ $uniqueActionId }}', () => { isOpen = false; });
    
    if ({{ $shouldRefresh ? 'true' : 'false' }}) {
        $wire.dispatch('close-preview-modal-{{ $uniqueActionId }}');

        $set('{{ $tableViewName }}', '{{ uniqid() }}');
        
        $wire.dispatch('open-preview-modal-{{ $uniqueActionId }}');
    }

    if ({{ $shouldPrint ? 'true' : 'false' }}) {
        window.printHTML(`{!! $printContent !!}`, '{{ $statePath }}', '{{ $uniqueActionId }}', $set);
    }
    "
    x-on:keydown.window.escape.capture="isOpen = false"
    :heading="$getPreviewModalHeading()">
    <div class="preview-table-wrapper space-y-4 fi-ta-ctn">
        <table class="preview-table" x-init="$wire.$on('print-table-{{ $uniqueActionId }}', function() {
            $set('{{ $tableViewName }}', 'print-{{ $uniqueActionId }}');
        })">
            <tr class="dark:border-gray-700">
                @foreach ($getAllTableColumns() as $column)
                    <th class="dark:border-gray-700">
                        {{ $column->getLabel() }}
                    </th>
                @endforeach
            </tr>
            @foreach ($getRows() as $row)
                <tr class="dark:border-gray-700">
                    @foreach ($getAllTableColumns() as $column)
                        <td class="dark:border-gray-700">
                            {{ $row[$column->getName()] }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
        <div>
            <x-filament::pagination :paginator="$getRows()" :page-options="$this->getTable()->getPaginationPageOptions()" class="preview-table-pagination px-3 py-3"/>
        </div>
    </div>
    <x-slot name="footer">
        @foreach ($getFooterActions() as $action)
            {{ $action }}
        @endforeach
    </x-slot>
</x-filament::modal>
