<div class="p-2 space-y-4">
    @if ($records->count())
        @foreach ($records as $record)
            @php
                // This is a trick to make $getRecord() available in the included view
                $getRecord = fn() => $record;
            @endphp
            @include('filament.resources.arsip-resource.arsip-table-item', [
                'actions' => $this->getTableActions(),
                'recordForActions' => $record,
            ])
        @endforeach
    @else
        <div class="p-4">
            {{ $this->getTable()->getEmptyState() }}
        </div>
    @endif
</div>
