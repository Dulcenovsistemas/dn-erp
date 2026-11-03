<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dia_zona', function (Blueprint $table) {
            $table->id();

            $table->foreignId('zona_id')
                ->constrained('zonas')
                ->cascadeOnDelete();

            $table->foreignId('dia_id')
                ->constrained('dias')
                ->cascadeOnDelete();

            $table->unique(['zona_id', 'dia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dia_zona');
    }
};