<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('backlogs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('project_id')->constrained()->cascadeOnDelete();
            $t->string('task_name');
            $t->text('description')->nullable();
            $t->enum('type', ['feature', 'bugfix', 'new screen'])->default('feature');
            $t->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
            $t->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $t->unsignedTinyInteger('priority')->default(3);
            $t->softDeletes();
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('backlogs');
    }
};
