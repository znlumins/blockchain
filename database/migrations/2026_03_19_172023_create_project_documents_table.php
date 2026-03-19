<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::disableForeignKeyConstraints();

        Schema::create('project_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('tipe_data'); 
            $table->string('file_path');
            $table->string('deskripsi');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void { 
        Schema::dropIfExists('project_documents'); 
    }
};