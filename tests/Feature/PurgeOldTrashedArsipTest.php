<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use App\Models\Arsip;
use Illuminate\Support\Str;

class PurgeOldTrashedArsipTest extends TestCase
{
    use RefreshDatabase;

    public function test_purge_old_trashed_arsip_removes_records_and_files()
    {
        Storage::fake('local');

        // Create a fake file and an Arsip record that references it
        $path = 'arsip/' . Str::random(10) . '.pdf';
        Storage::disk('local')->put($path, 'dummy content');

        $arsip = Arsip::create([
            'judul' => 'Test Arsip',
            'deskripsi' => 'Deskripsi',
            'file_path' => $path,
            'kategori_id' => null,
            'subjek_id' => null,
            'user_id' => null,
            'version' => 1,
        ]);

        // Soft delete and backdate deleted_at to > 1 year ago
        $arsip->delete();
        $arsip->deleted_at = now()->subYears(2);
        $arsip->save();

        // Ensure file exists before command
        $this->assertTrue(Storage::disk('local')->exists($path));

        // Run the artisan command
        $this->artisan('arsip:purge-old-trash')->assertExitCode(0);

        // Assert the record was hard-deleted
        $this->assertDatabaseMissing('arsips', ['id' => $arsip->id]);

        // Assert file removed
        $this->assertFalse(Storage::disk('local')->exists($path));
    }

    public function test_purge_does_not_remove_recently_trashed()
    {
        Storage::fake('local');

        $path = 'arsip/' . Str::random(10) . '.pdf';
        Storage::disk('local')->put($path, 'dummy content');

        $arsip = Arsip::create([
            'judul' => 'Recent Arsip',
            'deskripsi' => 'Deskripsi',
            'file_path' => $path,
            'kategori_id' => null,
            'subjek_id' => null,
            'user_id' => null,
            'version' => 1,
        ]);

        // Soft delete recently (deleted_at = now)
        $arsip->delete();
        $arsip->deleted_at = now();
        $arsip->save();

        $this->artisan('arsip:purge-old-trash')->assertExitCode(0);

        // Record should still exist in trash
        $this->assertDatabaseHas('arsips', ['id' => $arsip->id]);

        // File should still exist
        $this->assertTrue(Storage::disk('local')->exists($path));
    }
}
