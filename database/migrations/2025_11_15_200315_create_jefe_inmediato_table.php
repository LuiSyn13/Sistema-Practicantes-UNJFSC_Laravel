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
        Schema::create('jefe_inmediato', function (Blueprint $table) {
            $table->id();
            $table->string('nombres')->nullable();
            $table->string('dni')->nullable();
            $table->string('cargo')->nullable();
            $table->string('area')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('web')->nullable();
            $table->foreignId('id_practica')->constrained('practicas')->onDelete('restrict');
            $table->timestamps();
            $table->integer('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jefe_inmediato');
    }
};
