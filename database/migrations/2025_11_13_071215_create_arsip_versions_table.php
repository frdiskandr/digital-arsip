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
        Schema::create('arsip_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('version');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->string('original_file_name')->nullable();
            $table->foreignId('user_id')->comment('User who created this version')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_versions');
    }
};