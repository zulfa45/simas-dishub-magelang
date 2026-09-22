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
        Schema::create('incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda')->unique();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->string('asal_surat');
            $table->string('instansi_pengirim');
            $table->string('perihal');
            $table->text('ringkasan_isi');
            $table->foreignId('kategori_id')->constrained('letter_categories');
            $table->enum('sifat', ['biasa', 'penting', 'segera', 'rahasia'])->default('biasa');
            $table->enum('prioritas', ['rendah', 'normal', 'tinggi', 'urgent'])->default('normal');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['baru', 'dibaca', 'didistribusikan', 'dalam_tindak_lanjut', 'selesai', 'diarsipkan'])->default('baru');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_letters');
    }
};
