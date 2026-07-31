<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {

            // Eliminar la llave foránea
            $table->dropForeign(['sucursal_id']);

            // Eliminar la columna
            $table->dropColumn('sucursal_id');

            // Agregar zona
            $table->foreignId('zona_id')
                ->after('folio')
                ->constrained()
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {

            $table->dropForeign(['zona_id']);

            $table->dropColumn('zona_id');

            $table->foreignId('sucursal_id')
                ->after('folio')
                ->constrained()
                ->cascadeOnDelete();

        });
    }
};