<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('cedula', 20)->unique();
            $table->string('telefono', 15);
            $table->string('email', 255)->unique();
            $table->string('direccion', 255)->nullable();
            $table->string('cargo', 100);
            $table->decimal('salario', 10, 2);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            // Relaciones geográficas
            $table->foreignId('pais_id')->constrained('paises')->onDelete('restrict');
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('restrict');
            $table->foreignId('ciudad_id')->constrained('ciudads')->onDelete('restrict');

            // Relación con usuario asignado
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relación con el usuario que registró al empleado
            $table->foreignId('registradopor')->nullable()->constrained('users')->onDelete('set null');

            // Rol asignado al empleado
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');

            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
}
