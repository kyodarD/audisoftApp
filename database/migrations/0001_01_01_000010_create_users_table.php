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
        // Crear la tabla 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('estado')->default('1');  // Estado activo o inactivo
            $table->rememberToken();
            // Asegúrate de que 'role_id' sea unsignedBigInteger para coincidir con la columna 'id' de 'roles'
            $table->unsignedBigInteger('role_id')->nullable()->constrained('roles')->onDelete('set null'); // Relación con la tabla 'roles'
            $table->timestamps();
        });

        // Crear la tabla 'password_reset_tokens'
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email'); // Usar solo email en lugar de hacerla primary
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            $table->primary(['email', 'token']); // Asegura que cada combinación de email y token sea única
        });

        // Crear la tabla 'sessions'
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID como clave primaria
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Establecer la relación con la tabla 'users'
            $table->string('ip_address', 45)->nullable(); // Dirección IP con tamaño adecuado para IPv6
            $table->text('user_agent')->nullable(); // Agente de usuario
            $table->longText('payload'); // Información sobre la sesión
            $table->integer('last_activity')->index(); // Indicar el último momento de actividad
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down(): void
    {
        // Eliminar las tablas cuando se revierten las migraciones
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
