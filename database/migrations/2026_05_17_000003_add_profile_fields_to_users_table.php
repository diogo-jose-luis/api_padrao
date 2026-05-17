<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Campos adicionais do utilizador (perfil, cargo e departamento).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('genero')->nullable()->after('password');
            $table->string('fotografia')->nullable()->after('genero');
            $table->foreignId('cargo_id')->nullable()->after('fotografia')->constrained('positions')->nullOnDelete();
            $table->foreignId('departamento_id')->nullable()->after('cargo_id')->constrained('departments')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cargo_id']);
            $table->dropForeign(['departamento_id']);
            $table->dropColumn(['genero', 'fotografia', 'cargo_id', 'departamento_id']);
        });
    }
};
