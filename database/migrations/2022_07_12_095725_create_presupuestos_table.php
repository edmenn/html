<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();    // auto-increment and primary key
            $table->string('anho_fiscal', 4);
            $table->string('codigo', 12);
            $table->smallInteger('puerto_id');
            $table->string('descripcion', 255);
            $table->integer('costo');
            $table->integer('responsable_id');
            $table->smallInteger('estado_id');
            $table->timestamps();

            // INDEXES
            $table->foreign('puerto_id')->references('id')->on('puertos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('responsable_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('estado_id')->references('id')->on('estados')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presupuestos');
    }
}
