<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // CREATED, VOTED, UPDATED
            $table->string('model_type'); 
            $table->unsignedBigInteger('model_id');
            $table->json('data');
            $table->string('previous_hash')->nullable();
            $table->string('hash')->unique(); // SHA-256 Hash (Blockchain concept)
            $table->string('created_by');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('audit_logs'); }
};