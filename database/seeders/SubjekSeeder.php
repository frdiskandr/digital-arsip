<?php

namespace Database\Seeders;

use App\Models\Subjek;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Subjek::truncate();
        Schema::enableForeignKeyConstraints();

        $subjeks = [
            ['nama' => 'Administrasi Umum', 'color' => '#0EA5A4', 'deskripsi' => 'Dokumen administrasi umum seperti surat-menyurat, nota, memo.'],
            ['nama' => 'Keuangan', 'color' => '#2563EB', 'deskripsi' => 'Laporan keuangan, bukti pembayaran, invoice, kuitansi.'],
            ['nama' => 'Sumber Daya Manusia', 'color' => '#7C3AED', 'deskripsi' => 'Data karyawan, kontrak kerja, absensi, cuti.'],
            ['nama' => 'Hukum', 'color' => '#DC2626', 'deskripsi' => 'Perjanjian, kontrak, dokumen legal dan litigasi.'],
            ['nama' => 'Operasional', 'color' => '#059669', 'deskripsi' => 'Prosedur operasional, laporan operasional harian.'],
            ['nama' => 'IT & Infrastruktur', 'color' => '#0B7A75', 'deskripsi' => 'Dokumen teknis, spesifikasi, konfigurasi, tiket.'],
            ['nama' => 'Pengadaan / Logistik', 'color' => '#EA580C', 'deskripsi' => 'PO, kontrak vendor, faktur pembelian.'],
            ['nama' => 'Pemasaran & Komunikasi', 'color' => '#F97316', 'deskripsi' => 'Materi promosi, press release, kampanye marketing.'],
            ['nama' => 'Proyek', 'color' => '#7F1D1D', 'deskripsi' => 'Dokumen proyek, rencana, milestone, laporan progres.'],
            ['nama' => 'Audit & Kepatuhan', 'color' => '#0F172A', 'deskripsi' => 'Laporan audit, checklist kepatuhan, sertifikat.'],
        ];

        foreach ($subjeks as $s) {
            Subjek::create($s);
        }
    }
}
