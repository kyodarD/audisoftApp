<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('categoria_id')->unsigned();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio',8,0);
            $table->integer('stock');
            $table->date('fecha_vencimiento');
            $table->string('img')->nullable();
            $table->string('estado');
            $table->string('registradopor');
            $table->timestamps();
			$table->foreign('categoria_id')
                ->references('id')->on('categorias');
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
