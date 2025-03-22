<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID único de la compra
            $table->unsignedBigInteger('proveedor_id'); // ID del proveedor
            $table->timestamp('fecha_compra')->useCurrent(); // Fecha de la compra
            $table->decimal('total_compra', 10, 2); // Total de la compra
            $table->decimal('descuento_compra', 10, 2)->nullable(); // Descuento de la compra (nullable)
            $table->enum('estado_compra', ['pagado', 'pendiente', 'cancelado'])->default('pendiente'); // Estado de la compra
            $table->string('estado')->default('activo'); // Estado general (activo/inactivo)
            $table->unsignedBigInteger('registradopor'); // ID del usuario que registró la compra

            $table->timestamps(); // Fechas de creación y actualización

            // Relación con la tabla 'proveedores'
            $table->foreign('proveedor_id')
                  ->references('id')->on('proveedores')
                  ->onDelete('cascade');

            // Relación con la tabla 'users'
            $table->foreign('registradopor')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
