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
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_variante_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('sucursal_origen_id')
                ->nullable()
                ->constrained('sucursals')
                ->nullOnDelete();

            $table->foreignId('sucursal_destino_id')
                ->nullable()
                ->constrained('sucursals')
                ->nullOnDelete();

            $table->enum('tipo', [
                'transferencia',
                'entrada',
                'salida'
            ]);

            $table->integer('cantidad');


            $table->string('referencia')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
