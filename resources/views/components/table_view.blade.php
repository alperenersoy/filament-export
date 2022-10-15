<input id="{{ $getStatePath() }}" type="hidden" {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}">

<x-filament::modal id="preview-modal" width="6xl" display-classes="block" x-init="$wire.on('open-preview-modal-{{ $getUniqueActionId() }}', function() {
    triggerInputEvent('{{ $getStatePath() }}', '');
    isOpen = true;
});
$wire.on('close-preview-modal-{{ $getUniqueActionId() }}', () => { isOpen = false; });" :heading="$getPreviewModalHeading()">
    <div class="preview-table-wrapper space-y-4">
        <table class="preview-table" x-init="$wire.on('print-table-{{ $getUniqueActionId() }}', function() {
            triggerInputEvent('{{ $getStatePath() }}', 'print-{{ $getUniqueActionId() }}')
        })">
            <tr>
                @foreach ($getAllColumns() as $column)
                    <th wire:loading.remove>
                        {{ $column->getLabel() }}
                    </th>
                @endforeach
                <x-tables::loading-cell :colspan="$getAllColumns()->count()" wire:loading.class.remove.delay="hidden" class="hidden" />
            </tr>
            @foreach ($getRows() as $row)
                <tr>
                    @foreach ($getAllColumns() as $column)
                        <td wire:loading.remove>
                            {{ $row[$column->getName()] }}
                        </td>
                    @endforeach
                    <x-tables::loading-cell :colspan="$getAllColumns()->count()" wire:loading.class.remove.delay="hidden" class="hidden" />
                </tr>
            @endforeach
        </table>
        <div wire:loading.remove>
            {{-- <x-tables::pagination :paginator="$getRows()" :records-per-page-select-options="$this->getTable()->getRecordsPerPageSelectOptions()" /> --}}
        </div>
    </div>
    <x-slot name="footer">
        @foreach ($getFooterActions() as $action)
            {{ $action }}
        @endforeach
    </x-slot>
    @php
        $data = $this->mountedTableBulkAction ? $this->mountedTableBulkActionData : $this->mountedTableActionData;
    @endphp
    @if (is_array($data) &&
        array_key_exists('table_view', $data) &&
        $data['table_view'] == 'print-' . $getUniqueActionId())
        <script>
            printHTML(`{!! $this->printHTML !!}`, '{{ $getStatePath() }}', '{{ $getUniqueActionId() }}');
        </script>
    @endif
</x-filament::modal>
