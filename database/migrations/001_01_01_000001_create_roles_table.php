<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nombre único del rol
            $table->string('guard_name')->default('web'); // Necesario para Spatie
            $table->text('description')->nullable(); // Descripción opcional del rol
            $table->timestamps();

            // Agregar un índice para 'guard_name' si es necesario
            $table->index('guard_name');
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
