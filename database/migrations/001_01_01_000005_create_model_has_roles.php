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
        
            // Relaciones
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('model_id')->references('id')->on('users')->onDelete('cascade');
        
            // Clave primaria
            $table->primary(['role_id', 'model_id']);
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
