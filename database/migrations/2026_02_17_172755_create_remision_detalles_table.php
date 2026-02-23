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
       Schema::create('remision_detalles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('remision_id')
                ->constrained('remisiones')
                ->cascadeOnDelete();


            $table->foreignId('producto_variante_id')
                ->constrained('producto_variantes')
                ->cascadeOnDelete();

            $table->integer('cantidad');
            $table->text('notas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remision_detalles');
    }
};
