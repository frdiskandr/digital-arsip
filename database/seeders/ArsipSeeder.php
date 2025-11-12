<?php

namespace Database\Seeders;

use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\Subjek;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArsipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Arsip::truncate();
        Schema::enableForeignKeyConstraints();

        // Gather ids for relations
        $kategoriIds = Kategori::pluck('id')->toArray();
        $subjekIds = Subjek::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // A mix of common file extensions to simulate real-world documents
        $extensions = ['pdf', 'docx', 'doc', 'xlsx', 'xls', 'pptx', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'txt', 'md', 'mp4'];

        // Ensure storage directory exists
        Storage::makeDirectory('public/arsip');

        // Create 200 arsip with varied file types and optional subjek assignment
        for ($i = 0; $i < 200; $i++) {
            $model = Arsip::factory()->make();

            // randomly pick extension and build file
            $ext = $extensions[array_rand($extensions)];
            $base = now()->format('YmdHis') . '_' . bin2hex(random_bytes(4));
            $fileName = $base . '.' . $ext;

            // create simple placeholder content depending on type
            $content = match ($ext) {
                'pdf' => '%PDF-1.4\n%âãÏÓ\n',
                'jpg', 'jpeg', 'png', 'gif' => 'binary-image-placeholder',
                'mp4' => 'binary-video-placeholder',
                'zip' => 'PK\x03\x04',
                default => "Dummy content for {$fileName}",
            };

            Storage::put('public/arsip/' . $fileName, $content);

            $model->file_path = 'arsip/' . $fileName;
            $model->original_file_name = $fileName;

            // assign kategori, user, and occasionally a subjek
            $model->kategori_id = $kategoriIds ? $kategoriIds[array_rand($kategoriIds)] : null;
            $model->user_id = $userIds ? $userIds[array_rand($userIds)] : null;
            // 85% of records get a subjek
            $model->subjek_id = (count($subjekIds) && (mt_rand(1, 100) <= 85)) ? $subjekIds[array_rand($subjekIds)] : null;

            $model->save();
        }
    }
}
