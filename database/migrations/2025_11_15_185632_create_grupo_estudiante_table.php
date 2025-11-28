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
        Schema::create('grupo_estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_estudiante')->constrained('asignacion_persona')->onDelete('restrict');
            $table->foreignId('id_gp')->constrained('grupo_practica')->onDelete('restrict');
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
        Schema::dropIfExists('grupo_estudiante');
    }
};
