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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_alumno')->unique()->constrained('asignacion_persona')->onDelete('restrict')->onUpdate('cascade');
            $table->string('anexo_6')->nullable();
            $table->string('anexo_7')->nullable();
            $table->string('anexo_8')->nullable();
            $table->string('user_create')->nullable();
            $table->string('user_update')->nullable();
            $table->timestamps();
            $table->boolean('state')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluaciones');
    }
};
