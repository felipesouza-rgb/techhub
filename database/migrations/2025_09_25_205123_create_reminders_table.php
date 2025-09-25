<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration{public function up():void{Schema::create('reminders',function(Blueprint $t){$t->id();$t->foreignId('project_id')->constrained()->cascadeOnDelete();$t->foreignId('stakeholder_user_id')->constrained('users')->cascadeOnDelete();$t->date('notification_date');$t->softDeletes();$t->timestamps();});}public function down():void{Schema::dropIfExists('reminders');}};

