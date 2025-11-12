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
            ['nama' => 'Surat Masuk', 'color' => '#0EA5A4'],
            ['nama' => 'Surat Keluar', 'color' => '#2563EB'],
            ['nama' => 'Laporan', 'color' => '#7C3AED'],
            ['nama' => 'Notulen / Risalah', 'color' => '#F97316'],
            ['nama' => 'Kontrak', 'color' => '#DC2626'],
            ['nama' => 'SOP / Prosedur', 'color' => '#059669'],
            ['nama' => 'Keuangan', 'color' => '#0B7A75'],
            ['nama' => 'Personalia / SDM', 'color' => '#EA580C'],
            ['nama' => 'Proyek', 'color' => '#7F1D1D'],
            ['nama' => 'Presentasi / Materi', 'color' => '#0F172A'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
