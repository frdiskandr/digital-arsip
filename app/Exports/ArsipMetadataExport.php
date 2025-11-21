<?php

namespace App\Exports;

use App\Models\Arsip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;

class ArsipMetadataExport implements FromCollection, WithHeadings, WithMapping
{
    protected $records;

    public function __construct(Collection $records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        return $this->records;
    }

    public function headings(): array
    {
        return [
            'Judul',
            'Deskripsi',
            'Kategori',
            'Subjek',
            'Pengunggah',
            'Tanggal Upload',
            'Nama File Asli',
            'Versi',
        ];
    }

    public function map($arsip): array
    {
        return [
            $arsip->judul,
            $arsip->deskripsi,
            $arsip->kategori ? $arsip->kategori->nama : '-',
            $arsip->subjek ? $arsip->subjek->nama : '-',
            $arsip->user ? $arsip->user->name : '-',
            $arsip->created_at->format('Y-m-d H:i:s'),
            $arsip->original_file_name,
            $arsip->version,
        ];
    }
}
