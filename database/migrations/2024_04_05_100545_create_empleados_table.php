<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('cedula', 20)->unique(); // Aseguramos que la cédula sea única
            $table->string('telefono', 15); // Puedes especificar una longitud según el formato
            $table->string('email', 255)->unique();
            $table->string('direccion', 255)->nullable();
            $table->string('cargo', 100);
            $table->decimal('salario', 10, 2);
            $table->enum('estado', ['activo', 'inactivo']);
            
            // Relación con la tabla users
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con usuario que está asociado al empleado
            
            // Relación con el usuario que registra el empleado (usuario admin)
            $table->foreignId('registradopor')->nullable()->constrained('users', 'id')->onDelete('set null');

            // Relación con roles (uno a uno)
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null'); // Relación uno a uno con roles

            // Columna para almacenar la foto del empleado
            $table->string('photo')->nullable(); 

            // Índices para mejor rendimiento
            $table->index(['cedula', 'email']); // Si no son únicos, pero las consultas son frecuentes

            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
