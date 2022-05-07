<style type="text/css" media="print">
    html {
        width: 100%;
        height: 0;
    }

    body * {
        visibility: hidden;
        height: 0;
    }

    #printTable,
    #printTable * {
        visibility: visible;
    }

    #printTable {
        position: absolute;
        width: 100%;
        max-height: 100%;
        left: 0;
        top: 0;
    }

    #print-table {
        page-break-after: auto
    }

    #print-table tr {
        page-break-inside: avoid;
        page-break-after: auto
    }

    #print-table td {
        page-break-inside: avoid;
        page-break-after: auto
    }

</style>
<style style type="text/css" media="screen">
    #printTable {
        display: none;
    }

    .print-table-wrapper {
        max-height: min(600px, 80vh);
        overflow-y: scroll;
    }

</style>
<style type="text/css" media="all">
    #print-table {
        background: white;
        color: black;
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    #print-table td,
    #print-table th {
        border-color: #ededed;
        border-style: solid;
        border-width: 1px;
        font-size: 13px;
        line-height: 2;
        overflow: hidden;
        padding-left: 6px;
        word-break: normal;
    }

    #print-table th {
        font-weight: normal;
    }

</style>
<x-filament::modal id="preview-modal" width="6xl" display-classes="block" x-init="$wire.on('open-preview-modal-{{ $getUniqueActionId() }}', () => { isOpen = true; }); $wire.on('close-preview-modal-{{ $getUniqueActionId() }}', () => { isOpen = false; })" :heading="$getPreviewModalHeading()">
    <div class="print-table-wrapper">
        <table id="print-table">
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
    <script>
        function printTable() {
            var domClone = document.querySelector("#print-table").cloneNode(true);

            var printTable = document.getElementById("printTable");

            if (!printTable) {
                var printTable = document.createElement("div");
                printTable.id = "printTable";
                document.body.appendChild(printTable);
            }

            printTable.innerHTML = "";
            printTable.appendChild(domClone);
            window.print();
        }
        window.Livewire.on('print-table-{{ $getUniqueActionId() }}', () => printTable());
    </script>
    <x-slot name="footer">
        @foreach ($getFooterActions() as $action)
            {{ $action }}
        @endforeach
    </x-slot>
</x-filament::modal>
