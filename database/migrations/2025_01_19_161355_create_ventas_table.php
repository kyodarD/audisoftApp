<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID único de la venta
            $table->unsignedBigInteger('cliente_id'); // ID del cliente
            $table->timestamp('fecha_venta')->useCurrent(); // Fecha de la venta
            $table->decimal('total_venta', 10, 2); // Total de la venta
            $table->decimal('descuento_venta', 10, 2)->nullable(); // Descuento de la venta (nullable)
            $table->enum('estado_venta', ['pagado', 'pendiente', 'cancelado'])->default('pendiente'); // Estado de la venta
            $table->string('estado')->default('activo'); // Estado de la venta, por defecto "activo"
            $table->unsignedBigInteger('registradopor'); // ID del usuario que registró la venta

            $table->timestamps(); // Fechas de creación y actualización

            // Relación con la tabla 'clientes' (clave foránea)
            $table->foreign('cliente_id')
                  ->references('id')->on('clientes')
                  ->onDelete('cascade');

            // Relación con la tabla 'users' para registrar qué usuario realizó la venta
            $table->foreign('registradopor')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
