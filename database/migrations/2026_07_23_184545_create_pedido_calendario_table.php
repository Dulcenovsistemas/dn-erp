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
            Schema::create('pedido_calendario', function (Blueprint $table) {

                $table->id();

                $table->foreignId('sucursal_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->tinyInteger('dia_pedido');
                // 0 domingo
                // 1 lunes
                // 2 martes
                // ...
                // 6 sábado

                $table->unsignedTinyInteger('dias_entrega');

                $table->boolean('activo')->default(true);

                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_calendario');
    }
};
