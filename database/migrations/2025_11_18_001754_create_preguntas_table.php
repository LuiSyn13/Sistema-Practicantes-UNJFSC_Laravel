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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta', 255);
            $table->foreignId('id_ap')->constrained('asignacion_persona')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->boolean('state')->default(true); // habilitada/deshabilitada
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preguntas');
    }
};
