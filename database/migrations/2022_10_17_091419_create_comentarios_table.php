<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();    // auto-increment and primary key
            $table->integer('proyecto_id')->nullable();
            $table->integer('subproyecto_id')->nullable();
            $table->text('comentario');
            $table->timestamps();

            // INDEXES
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('subproyecto_id')->references('id')->on('subproyectos')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}
