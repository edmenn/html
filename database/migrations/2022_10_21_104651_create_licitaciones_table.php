<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licitaciones', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();    // auto-increment and primary key
            $table->integer('proyecto_id')->nullable();
            $table->integer('subproyecto_id')->nullable();
            $table->smallInteger('proveedor_id');
            $table->string('concepto', 255);
            $table->bigInteger('monto'); // 2^63-1, validation -> 999999999999
            $table->text('comentarios');
            $table->timestamps();

            // INDEXES
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('subproyecto_id')->references('id')->on('subproyectos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licitaciones');
    }
}
