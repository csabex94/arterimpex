@props([
   'headerItems' => ['Customer', 'Date', 'Status', 'Amount'],
   'bodyItems' => [],
   'cells' => []
])

<flux:table>
    <flux:table.columns>
        @foreach ($headerItems as $headerItem)
            <flux:table.column>{{ $headerItem }}</flux:table.column>
        @endforeach
    </flux:table.columns>

    <flux:table.rows>
        @foreach ($bodyItems as $bodyItem)
            <flux:table.row>
                @foreach ($cells as $cell)
                    <flux:table.cell>{{ $bodyItem[$cell] }}</flux:table.cell>
                @endforeach
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
