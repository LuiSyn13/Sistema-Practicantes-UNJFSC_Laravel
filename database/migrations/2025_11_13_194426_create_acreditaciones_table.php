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
        Schema::create('acreditaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ap')->constrained('asignacion_persona')->onDelete('restrict');
            $table->string('estado_acreditacion')->default('Pendiente');
            $table->text('observacion')->nullable();
            $table->timestamp('f_acreditacion')->nullable();
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
        Schema::dropIfExists('acreditaciones');
    }
};
