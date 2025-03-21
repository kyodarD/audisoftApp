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
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type'); // Sin valor predeterminado, se pasará dinámicamente
            $table->unsignedBigInteger('model_id'); // Este será el ID del usuario o empleado, por ejemplo

            // Relación con permisos
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            // Índices adicionales para optimización de búsquedas
            $table->index(['model_id', 'model_type']);
            $table->index(['permission_id', 'model_id', 'model_type']);

            // Clave primaria compuesta
            $table->primary(['permission_id', 'model_id']);
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_permissions');
    }
};
