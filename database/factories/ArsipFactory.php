<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Arsip>
 */
class ArsipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Storage::makeDirectory('public/arsip');
        $fileName = $this->faker->word() . '.txt';
        Storage::put('public/arsip/' . $fileName, 'This is a dummy file.');
        $date = $this->faker->dateTimeBetween('-1 year', 'now');

        return [
            'judul' => $this->faker->sentence(),
            'deskripsi' => $this->faker->paragraph(),
            'tanggal_arsip' => $date,
            'file_path' => 'arsip/' . $fileName,
            'original_file_name' => $fileName,
            'kategori_id' => Kategori::inRandomOrder()->first()->id ?? Kategori::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
