<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');

            // Foreign key solo para role_id
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            // Índices para búsqueda polimórfica (no foreign key directa a users)
            $table->index(['model_id', 'model_type']);

            // Clave primaria compuesta
            $table->primary(['role_id', 'model_id', 'model_type'], 'model_has_roles_primary');
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_roles');
    }
};
