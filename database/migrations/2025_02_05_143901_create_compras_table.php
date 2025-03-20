<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateComprasTable extends Migration
{
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID único de la compra
            $table->unsignedBigInteger('cliente_id'); // ID del cliente asociado a la compra
            $table->timestamp('fecha_compra')->default(DB::raw('current_timestamp()')); // Fecha y hora de la compra
            $table->decimal('total_compra', 10, 2); // Total de la compra
            $table->decimal('descuento_compra', 10, 2)->nullable(); // Descuento de la compra (nullable)
            $table->enum('estado_compra', ['pagado', 'pendiente', 'cancelado'])->default('pagado'); // Estado de la compra
            $table->string('estado')->default('activo'); // Estado general de la compra, por defecto "activo"
            $table->unsignedBigInteger('registradopor'); // ID del usuario que registró la compra
            $table->bigInteger('producto_id')->unsigned(); // Relación con el producto
            $table->integer('cantidad_producto'); // Cantidad comprada del producto
            $table->decimal('precio_unitario_producto', 10, 2); // Precio unitario del producto en la compra
            $table->decimal('subtotal_producto', 10, 2); // Subtotal por producto (cantidad * precio unitario)
            $table->timestamps(); // Fechas de creación y actualización

            // Relación con la tabla 'clientes' (clave foránea)
            $table->foreign('cliente_id')
                  ->references('id')->on('clientes') // Relación con la tabla 'clientes'
                  ->onDelete('cascade'); // Eliminar compras si se elimina un cliente

            // Relación con la tabla 'users' para registrar qué usuario realizó la compra
            $table->foreign('registradopor')
                  ->references('id')->on('users') // Relacionado con la tabla 'users'
                  ->onDelete('cascade'); // Eliminar compras si se elimina un usuario

            // Relación con la tabla 'productos' (clave foránea)
            $table->foreign('producto_id')
                  ->references('id')->on('productos') // Relación con la tabla 'productos'
                  ->onDelete('cascade'); // Eliminar compras si se elimina un producto
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
