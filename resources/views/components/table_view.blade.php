<x-filament::modal id="preview-modal" width="6xl" display-classes="block" x-init="$wire.on('open-preview-modal-{{ $getUniqueActionId() }}', () => { isOpen = true; }); $wire.on('close-preview-modal-{{ $getUniqueActionId() }}', () => { isOpen = false; })" :heading="$getPreviewModalHeading()">
    <div class="preview-table-wrapper">
        <table class="preview-table" x-init="$wire.on('print-table-{{ $getUniqueActionId() }}', () => printTable($el))">
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
    </div>
    <x-slot name="footer">
        @foreach ($getFooterActions() as $action)
            {{ $action }}
        @endforeach
    </x-slot>
</x-filament::modal>
