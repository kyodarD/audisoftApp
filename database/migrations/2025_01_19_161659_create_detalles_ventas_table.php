<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesVentasTable extends Migration
{
    public function up()
    {
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID único del detalle de la venta
            $table->bigInteger('venta_id')->unsigned(); // Relación con la tabla 'ventas'
            $table->bigInteger('producto_id')->unsigned(); // Relación con la tabla 'productos'
            $table->integer('cantidad'); // Cantidad del producto vendido
            $table->decimal('precio_unitario', 10, 2); // Precio unitario del producto
            $table->decimal('subtotal', 10, 2); // Subtotal (cantidad * precio_unitario)
            $table->unsignedBigInteger('registradopor'); // ID del usuario que registró el detalle
            $table->timestamps(); // Fechas de creación y actualización

            // Clave foránea para 'ventas'
            $table->foreign('venta_id')
                  ->references('id')->on('ventas')
                  ->onDelete('cascade'); // Eliminar detalles si se elimina una venta

            // Clave foránea para 'productos'
            $table->foreign('producto_id')
                  ->references('id')->on('productos')
                  ->onDelete('cascade'); // Eliminar detalles si se elimina un producto

            // Clave foránea para 'users'
            $table->foreign('registradopor')
                  ->references('id')->on('users')
                  ->onDelete('cascade'); // Eliminar detalles si se elimina el usuario
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_ventas');
    }
}
