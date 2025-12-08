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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_persona')->constrained('asignacion_persona')->onDelete('restrict');
            $table->foreignId('id_pregunta')->constrained('preguntas')->onDelete('restrict');
            $table->text('respuesta');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
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
        Schema::dropIfExists('respuestas');
    }
};
