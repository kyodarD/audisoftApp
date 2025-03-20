<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesComprasTable extends Migration
{
    public function up()
    {
        Schema::create('detalles_compras', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID único del detalle de compra
            $table->bigInteger('compra_id')->unsigned(); // Relación con la tabla 'compras'
            $table->bigInteger('producto_id')->unsigned(); // Relación con la tabla 'productos'
            $table->unsignedBigInteger('registradopor'); // ID del usuario que registró el detalle
            $table->timestamps(); // Fechas de creación y actualización
            
            // Claves foráneas
            $table->foreign('compra_id')
                  ->references('id')->on('compras')
                  ->onDelete('cascade'); // Eliminar relación si se elimina la compra
                  
            $table->foreign('producto_id')
                  ->references('id')->on('productos')
                  ->onDelete('cascade'); // Eliminar relación si se elimina el producto

            $table->foreign('registradopor')
                  ->references('id')->on('users')
                  ->onDelete('cascade'); // Eliminar relación si se elimina el usuario
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_compras');
    }
}
