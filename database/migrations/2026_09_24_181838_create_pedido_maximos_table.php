<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedido_maximos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('zona_id')
                ->constrained('zonas')
                ->cascadeOnDelete();

            $table->unsignedInteger('maximo')
                ->default(0);

            $table->timestamps();

            // Una configuración de máximo por zona
            $table->unique('zona_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_maximos');
    }
};