<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID único del cliente
            $table->string('nombre'); // Nombre del cliente
            $table->string('cedula')->unique();
            $table->string('direccion')->nullable(); // Dirección del cliente
            $table->string('telefono')->nullable(); // Teléfono del cliente
            $table->string('email')->nullable(); // Correo electrónico del cliente
            $table->string('estado')->default('activo'); // Estado de la venta, por defecto "activo"
            $table->string('registradopor')->nullable(); // Quién registró la venta
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
