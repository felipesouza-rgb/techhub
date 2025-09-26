<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stakeholders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('role')->nullable(); // opcional (ex.: Cliente, PM, etc.)
            $table->timestamps();

            $table->unique(['project_id', 'email']); // evita duplicados no mesmo projeto
        });
    }

    public function down(): void {
        Schema::dropIfExists('stakeholders');
    }
};
