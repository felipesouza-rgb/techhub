<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reminders', function (Blueprint $table) {
            if (Schema::hasColumn('reminders', 'stakeholder_user_id')) {
                // Primeiro tenta dropar a FK pelo helper do Laravel
                try {
                    $table->dropConstrainedForeignId('stakeholder_user_id');
                } catch (\Throwable $e) {
                    // Nome da FK pode ser diferente; tenta o padrão e, por fim, só dropar a coluna
                    try {
                        $table->dropForeign('reminders_stakeholder_user_id_foreign');
                        $table->dropColumn('stakeholder_user_id');
                    } catch (\Throwable $e2) {
                        // fallback final
                        $table->dropColumn('stakeholder_user_id');
                    }
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('reminders', function (Blueprint $table) {
            // Se precisar voltar, recria como nullable (para não travar inserts antigos)
            if (!Schema::hasColumn('reminders', 'stakeholder_user_id')) {
                $table->foreignId('stakeholder_user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }
};
