<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('reminders', function (Blueprint $table) {
            if (!Schema::hasColumn('reminders', 'stakeholder_id')) {
                $table->foreignId('stakeholder_id')
                    ->nullable()
                    ->after('project_id')
                    ->constrained()
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('reminders', 'notification_date')) {
                $table->date('notification_date')->nullable()->after('stakeholder_id');
            }

            if (!Schema::hasColumn('reminders', 'days_after_deploy')) {
                $table->unsignedInteger('days_after_deploy')->default(0)->after('notification_date');
            }

            // se tiver um user_id antigo, remove:
            if (Schema::hasColumn('reminders', 'user_id')) {
                try {
                    $table->dropConstrainedForeignId('user_id');
                } catch (\Throwable $e) {
                    // fallback caso o nome da FK seja diferente
                    $table->dropColumn('user_id');
                }
            }
        });
    }

    public function down(): void {
        Schema::table('reminders', function (Blueprint $table) {
            if (Schema::hasColumn('reminders', 'stakeholder_id')) {
                $table->dropConstrainedForeignId('stakeholder_id');
            }
            if (Schema::hasColumn('reminders', 'notification_date')) {
                $table->dropColumn('notification_date');
            }
            if (Schema::hasColumn('reminders', 'days_after_deploy')) {
                $table->dropColumn('days_after_deploy');
            }
        });
    }
};
