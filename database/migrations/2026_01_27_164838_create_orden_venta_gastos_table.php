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
            Schema::create('orden_venta_gastos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('orden_venta_id')
                ->constrained('ordenes_venta')
                ->cascadeOnDelete();

            $table->string('concepto');
            $table->decimal('monto', 12, 2);

            // 📸 Comprobante
            $table->string('comprobante_path');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_venta_gastos');
    }
};
