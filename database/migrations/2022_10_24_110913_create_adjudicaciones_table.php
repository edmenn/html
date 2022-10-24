<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjudicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjudicaciones', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();    // auto-increment and primary key
            $table->integer('licitacion_id')->nullable();
            $table->date('fecha_adjudicacion', 255);
            $table->timestamps();

            // INDEXES
            $table->foreign('licitacion_id')->references('id')->on('licitaciones')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjudicaciones');
    }
}
