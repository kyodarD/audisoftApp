<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('cedula')->unique();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->text('direccion')->nullable();
            $table->string('estado')->default('activo');
            $table->string('registradopor')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
