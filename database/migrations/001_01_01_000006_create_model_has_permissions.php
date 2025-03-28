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
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');

            // Foreign key a permissions
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            // Índices para optimización de búsquedas
            $table->index(['model_id', 'model_type']);
            $table->index(['permission_id', 'model_id', 'model_type']);

            // Clave primaria compuesta correcta
            $table->primary(['permission_id', 'model_id', 'model_type'], 'model_has_permissions_primary');
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
