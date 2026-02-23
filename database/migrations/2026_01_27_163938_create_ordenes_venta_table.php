<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ordenes_venta', function (Blueprint $table) {
            $table->id();

            $table->string('folio')->unique();

            $table->foreignId('planta_id')
                ->constrained('sucursals')
                ->cascadeOnDelete();

            $table->foreignId('sucursal_id')
                ->constrained('sucursals')
                ->cascadeOnDelete();

            $table->enum('estado', [
                'en_proceso',
                'confirmada',
                'cancelada'
            ])->default('en_proceso');

            $table->dateTime('fecha');
            $table->date('fecha_entrega')->nullable();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total_mermas', 12, 2)->default(0);
            $table->decimal('total_gastos', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->text('notas')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_venta');
    }
};
