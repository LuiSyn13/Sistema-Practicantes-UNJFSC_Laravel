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
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');                    // Nombre descriptivo del recurso
            $table->string('tipo', 50);                  // carga_lectiva, horario, fut, anexo_7, otros, etc.
            $table->string('ruta');                      // Ruta del archivo
            $table->text('descripcion')->nullable();     // Descripción opcional
            $table->unsignedBigInteger('subido_por_ap'); // ID de asignacion_persona que subió
            $table->unsignedBigInteger('id_sa')->nullable(); // Sección académica (para filtrar por escuela)
            $table->timestamps();
            $table->integer('state')->default(1);        // 1=activo, 0=inactivo
            
            $table->foreign('subido_por_ap')->references('id')->on('asignacion_persona')->onDelete('restrict');
            $table->foreign('id_sa')->references('id')->on('seccion_academica')->onDelete('restrict');
            
            $table->index(['tipo', 'state']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recursos');
    }
};
