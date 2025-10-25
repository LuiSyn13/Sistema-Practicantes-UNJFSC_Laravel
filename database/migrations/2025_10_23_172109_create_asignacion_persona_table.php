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
        Schema::create('asignacion_persona', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_semestre');
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_rol');
            $table->unsignedBigInteger('id_escuela');
            $table->unsignedBigInteger('id_facultad');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_semestre')->references('id')->on('semestres');
            $table->foreign('id_persona')->references('id')->on('personas');
            $table->foreign('id_rol')->references('id')->on('type_users');
            $table->foreign('id_escuela')->references('id')->on('escuelas');
            $table->foreign('id_facultad')->references('id')->on('facultades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignacion_persona');
    }
};
