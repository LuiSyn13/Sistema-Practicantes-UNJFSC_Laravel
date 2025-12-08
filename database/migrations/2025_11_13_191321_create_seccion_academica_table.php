<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seccion_academica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_semestre');
            $table->unsignedBigInteger('id_facultad');
            $table->unsignedBigInteger('id_escuela');
            $table->string('seccion');
            $table->timestamps();
            $table->boolean('state')->default(true);

            $table->foreign('id_semestre')->references('id')->on('semestres');
            $table->foreign('id_facultad')->references('id')->on('facultades');
            $table->foreign('id_escuela')->references('id')->on('escuelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secciones');
    }
};
