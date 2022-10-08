<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->smallInteger('id')->autoIncrement();    // auto-increment and primary key
            $table->string('nombre_fantasia', 150);
            $table->string('razon_social', 150);
            $table->string('ruc', 15);
            $table->string('telefono', 15)->nullable();
            $table->string('direccion', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
