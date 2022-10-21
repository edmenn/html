<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();    // auto-increment and primary key
            $table->integer('proyecto_id')->nullable();
            $table->integer('subproyecto_id')->nullable();
            $table->integer('licitacion_id')->nullable();
            $table->smallInteger('tipo_documento_id');
            $table->string('nombre', 50);
            $table->string('archivo', 50);
            $table->timestamps();

            // INDEXES
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('subproyecto_id')->references('id')->on('subproyectos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('licitacion_id')->references('id')->on('licitaciones')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documento')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
