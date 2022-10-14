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
            $table->smallInteger('anho_fiscal');
            $table->smallInteger('codigo');
            $table->smallInteger('localidad_id');
            $table->string('nombre', 150);
            $table->string('descripcion', 255);
            $table->integer('costo');
            $table->smallInteger('departamento_id');
            $table->integer('responsable_id');
            $table->smallInteger('estado_id');
            $table->enum('tipo', ['CAPEX', 'OPEX']);
            $table->timestamps();

            // INDEXES
            $table->foreign('localidad_id')->references('id')->on('localidades')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onUpdate('cascade')->onDelete('restrict');
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
