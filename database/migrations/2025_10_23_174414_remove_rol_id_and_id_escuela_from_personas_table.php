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
        Schema::table('personas', function (Blueprint $table) {
            // Eliminar claves foráneas primero
            $table->dropForeign(['rol_id']);
            $table->dropForeign(['id_escuela']);
            
            // Eliminar las columnas
            $table->dropColumn(['rol_id', 'id_escuela']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personas', function (Blueprint $table) {
            // Recrear las columnas
            $table->unsignedBigInteger('rol_id')->nullable();
            $table->unsignedBigInteger('id_escuela')->nullable();
            
            // Recrear las claves foráneas
            $table->foreign('rol_id')->references('id')->on('type_users');
            $table->foreign('id_escuela')->references('id')->on('escuelas');
        });
    }
};
