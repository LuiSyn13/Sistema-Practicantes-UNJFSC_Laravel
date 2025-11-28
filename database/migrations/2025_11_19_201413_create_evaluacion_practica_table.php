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
        Schema::create('evaluacion_practica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ap')->constrained('asignacion_persona')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_modulo')->constrained('modulos')->onDelete('restrict')->onUpdate('cascade');
            $table->string('estado_evaluacion')->default('Pendiente');
            $table->text('observacion')->nullable();
            $table->date('f_evaluacion')->nullable();
            $table->timestamps();
            $table->boolean('state')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluacion_practica');
    }
};
