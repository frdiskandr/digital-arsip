<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Kategori::truncate();
        Schema::enableForeignKeyConstraints();

        $kategoris = [
            ['nama' => 'Surat Masuk'],
            ['nama' => 'Surat Keluar'],
            ['nama' => 'Laporan Keuangan'],
            ['nama' => 'Dokumen Proyek'],
            ['nama' => 'Materi Rapat'],
            ['nama' => 'Sumber Daya Manusia'],
            ['nama' => 'Legal'],
            ['nama' => 'Marketing'],
            ['nama' => 'IT'],
            ['nama' => 'Umum'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}