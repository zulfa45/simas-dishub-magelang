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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_letter_id')->constrained('incoming_letters')->cascadeOnDelete();
            $table->string('title');
            $table->text('instruction');
            $table->enum('recipient_type', ['individu', 'bagian', 'semua_karyawan']);
            $table->datetime('deadline')->nullable();
            $table->enum('priority', ['rendah', 'normal', 'tinggi', 'urgent'])->default('normal');
            $table->enum('status', ['belum_dibaca', 'dibaca', 'diterima', 'dalam_proses', 'selesai'])->default('belum_dibaca');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
