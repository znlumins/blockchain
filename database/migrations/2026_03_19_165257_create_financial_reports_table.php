<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::disableForeignKeyConstraints(); // MATIKAN PENGECEKAN SEMENTARA

        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('jenis', ['pengeluaran', 'pemasukan']);
            $table->string('uraian');
            $table->decimal('volume', 10, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->decimal('jumlah', 15, 2);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints(); // NYALAKAN KEMBALI
    }
    public function down(): void { Schema::dropIfExists('financial_reports'); }
};