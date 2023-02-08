<input id="{{ $getStatePath() }}" type="hidden" {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}">

<x-filament-support::modal id="preview-modal" width="7xl" display-classes="block" x-init="$wire.on('open-preview-modal-{{ $getUniqueActionId() }}', function() {
    triggerInputEvent('{{ $getStatePath() }}', '{{ $shouldRefresh() ? 'refresh' : '' }}');
    isOpen = true;
});
$wire.on('close-preview-modal-{{ $getUniqueActionId() }}', () => { isOpen = false; });" :heading="$getPreviewModalHeading()">
    <div class="preview-table-wrapper space-y-4">
        <table class="preview-table" x-init="$wire.on('print-table-{{ $getUniqueActionId() }}', function() {
            triggerInputEvent('{{ $getStatePath() }}', 'print-{{ $getUniqueActionId() }}')
        })">
            <tr>
                @foreach ($getAllColumns() as $column)
                    <th>
                        {{ $column->getLabel() }}
                    </th>
                @endforeach
            </tr>
            @foreach ($getRows() as $row)
                <tr>
                    @foreach ($getAllColumns() as $column)
                        <td>
                            {{ $row[$column->getName()] }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
        <div>
            <x-tables::pagination :paginator="$getRows()" :records-per-page-select-options="$this->getTable()->getRecordsPerPageSelectOptions()" />
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
    @if ($shouldRefresh())
        <script>
            window.Livewire.emit("close-preview-modal-{{ $getUniqueActionId() }}");

            triggerInputEvent('{{ $getStatePath() }}', 'refresh');

            window.Livewire.emit("open-preview-modal-{{ $getUniqueActionId() }}");
        </script>
    @endif
</x-filament-support::modal>
