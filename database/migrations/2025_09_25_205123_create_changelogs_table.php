<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration{public function up():void{Schema::create('changelogs',function(Blueprint $t){$t->id();$t->foreignId('project_id')->constrained()->cascadeOnDelete();$t->date('deploy_date')->nullable();$t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();$t->string('version');$t->enum('status',['deploy_pending','deployed','rollback'])->default('deploy_pending');$t->foreignId('backlog_id')->nullable()->constrained('backlogs')->nullOnDelete();$t->softDeletes();$t->timestamps();});}public function down():void{Schema::dropIfExists('changelogs');}};

