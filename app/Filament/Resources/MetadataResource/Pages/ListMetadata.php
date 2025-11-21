<?php

namespace App\Filament\Resources\MetadataResource\Pages;

use App\Exports\ArsipMetadataExport;
use App\Filament\Resources\MetadataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListMetadata extends ListRecords
{
    protected static string $resource = MetadataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    // Get the filtered query
                    $query = $this->getFilteredTableQuery();
                    
                    // Execute the query to get the records
                    $records = $query->get();

                    // Download the Excel file
                    return Excel::download(new ArsipMetadataExport($records), 'metadata-arsip-' . date('Y-m-d-His') . '.xlsx');
                }),
        ];
    }
}
