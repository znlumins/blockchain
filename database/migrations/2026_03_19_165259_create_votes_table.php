<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::disableForeignKeyConstraints(); // MATIKAN PENGECEKAN SEMENTARA

        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('suara', ['setuju', 'tidak_setuju']);
            $table->timestamps();
            $table->unique(['user_id', 'project_id']); 
        });

        Schema::enableForeignKeyConstraints(); // NYALAKAN KEMBALI
    }
    public function down(): void { Schema::dropIfExists('votes'); }
};