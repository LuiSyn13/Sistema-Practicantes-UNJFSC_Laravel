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
        Schema::create('personas', function (Blueprint $table) {
            
            $table->id();
            $table->string('codigo', 10)->nullable();
            $table->string('dni', 8)->nullable();
            $table->string('nombres', 50)->nullable();
            $table->string('apellidos', 50)->nullable();
            $table->string('celular', 9)->nullable();
            $table->string('sexo', 1)->nullable();
            $table->string('ruta_foto')->nullable();
            $table->string('correo_inst', 150)->nullable();
            $table->string('departamento', 50)->nullable();
            $table->string('provincia', 50)->nullable();
            $table->string('distrito', 50)->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();
            $table->boolean('state')->default(true);
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
