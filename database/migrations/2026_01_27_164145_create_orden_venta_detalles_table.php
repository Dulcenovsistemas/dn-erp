<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orden_venta_detalles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('orden_venta_id')
                ->constrained('ordenes_venta')
                ->cascadeOnDelete();

            $table->foreignId('producto_variante_id')
                ->constrained('producto_variantes')
                ->cascadeOnDelete();

            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total', 12, 2);

            $table->text('notas')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_venta_detalles');
    }
};
