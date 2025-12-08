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
        Schema::table('practicas', function (Blueprint $table) {
            $table->decimal('calificacion', 5, 2)->nullable()->after('observacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practicas', function (Blueprint $table) {
            $table->dropColumn('calificacion');
        });
    }
};
