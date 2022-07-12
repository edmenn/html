<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();    // auto-increment and primary key
            $table->string('nombre', 150);
            $table->string('descripcion', 255);
            $table->string('anho_fiscal', 4);
            $table->string('codigo', 12);
            $table->smallInteger('puerto_id');
            $table->smallInteger('departamento_id');
            $table->integer('user_id');
            $table->integer('costo');
            $table->smallInteger('estado_id');
            $table->integer('contratado');
            $table->timestamps();

            // INDEXES
            $table->foreign('puerto_id')->references('id')->on('puertos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
