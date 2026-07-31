<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedido_detalles', function (Blueprint $table) {

            $table->foreignId('producto_variante_id')
                ->after('producto_id')
                ->constrained('producto_variantes')
                ->restrictOnDelete();

            $table->date('fecha')
                ->after('producto_variante_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
