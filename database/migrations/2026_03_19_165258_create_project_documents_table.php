<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proyek');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi');
            $table->decimal('anggaran', 15, 2);
            $table->year('tahun');
            $table->enum('status', ['usulan', 'proses', 'selesai'])->default('usulan');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('projects'); }
};