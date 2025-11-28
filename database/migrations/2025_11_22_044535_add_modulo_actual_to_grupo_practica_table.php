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
        Schema::table('grupo_practica', function (Blueprint $table) {
        $table->unsignedBigInteger('id_modulo')->default(1)->after('id_sa'); // O donde prefieras
        // Si tienes una tabla 'modulos', añade la llave foránea.
        $table->foreign('id_modulo')->references('id')->on('modulos');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grupo_practica', function (Blueprint $table) {
            //
        });
    }
};
