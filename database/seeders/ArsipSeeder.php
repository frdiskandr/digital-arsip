<?php

namespace Database\Seeders;

use App\Models\Arsip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
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

        Arsip::factory(100)->create();
    }
}