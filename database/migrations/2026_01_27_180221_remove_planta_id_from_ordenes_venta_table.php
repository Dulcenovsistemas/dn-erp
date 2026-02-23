<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ordenes_venta', function (Blueprint $table) {
            $table->dropForeign(['planta_id']);
            $table->dropColumn('planta_id');
        });
    }

    public function down()
    {
        Schema::table('ordenes_venta', function (Blueprint $table) {
            $table->foreignId('planta_id')
                ->constrained('sucursals');
        });
    }

};
