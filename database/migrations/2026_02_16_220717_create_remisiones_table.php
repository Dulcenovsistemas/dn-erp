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
        Schema::create('remisiones', function (Blueprint $table) {
            $table->id();

            $table->string('folio')->unique();

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


            $table->text('notas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remisiones');
    }
};
