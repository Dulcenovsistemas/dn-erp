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
        Schema::create('orden_venta_mermas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('orden_venta_id')
                ->constrained('ordenes_venta')
                ->cascadeOnDelete();

            $table->foreignId('producto_variante_id')
                ->constrained('producto_variantes')
                ->cascadeOnDelete();

            $table->integer('cantidad');
            $table->decimal('monto', 12, 2);

            // 🔀 Tipo de merma
            $table->enum('tipo_merma', [
                'transporte',
                'sucursal'
            ]);

            // 🏭 Solo si es sucursal
            $table->enum('origen_sucursal', [
                'fabrica',
                'sucursal'
            ])->nullable();

            // 📦 Lote afectado
            $table->string('lote')->nullable();

            // 📸 Evidencia
            $table->string('imagen_path');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_venta_mermas');
    }
};
