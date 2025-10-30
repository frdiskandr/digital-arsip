<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter existing `arsips` table to add tanggal_arsip and original_file_name.
        Schema::table('arsips', function (Blueprint $table) {
            if (!Schema::hasColumn('arsips', 'tanggal_arsip')) {
                $table->date('tanggal_arsip')->after('deskripsi')->nullable();
            }
            if (!Schema::hasColumn('arsips', 'original_file_name')) {
                $table->string('original_file_name')->after('file_path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsips', function (Blueprint $table) {
            if (Schema::hasColumn('arsips', 'original_file_name')) {
                $table->dropColumn('original_file_name');
            }
            if (Schema::hasColumn('arsips', 'tanggal_arsip')) {
                $table->dropColumn('tanggal_arsip');
            }
        });
    }
};
