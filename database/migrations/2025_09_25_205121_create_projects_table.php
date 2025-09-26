<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->text('description')->nullable();
            $t->string('stakeholder_name')->nullable();
            $t->softDeletes();
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
