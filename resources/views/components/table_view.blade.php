@php
    $uniqueActionId = $getUniqueActionId();

    $statePath = $getStatePath();
@endphp

<input id="{{ $statePath }}" type="hidden" {{ $applyStateBindingModifiers('wire:model') }}="{{ $statePath }}">

<x-filament::modal id="preview-modal" width="7xl"
    x-init="$wire.$on('open-preview-modal-{{ $uniqueActionId }}', function() {
        $wire.$set('{{ $statePath }}', '{{ uniqid() }}');
        isOpen = true;
    });

    $wire.$on('close-preview-modal-{{ $uniqueActionId }}', () => { isOpen = false; });
    "
    :heading="$getPreviewModalHeading()"
    :footer-actions="$getFooterActions()">
    <div class="preview-table-wrapper">
        <div class="preview-table-container">
            <table class="preview-table" x-init="$wire.$on('print-table-{{ $uniqueActionId }}', function() {
                $wire.$set('{{ $statePath }}', 'print-{{ $uniqueActionId }}');
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
        </div>
        <div>
            <x-filament::pagination :paginator="$getRows()" :page-options="$this->getTable()->getPaginationPageOptions()" class="preview-table-pagination"/>
        </div>
    </div>
</x-filament::modal>
