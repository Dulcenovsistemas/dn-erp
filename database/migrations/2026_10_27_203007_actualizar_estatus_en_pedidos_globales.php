
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE pedidos_globales
            MODIFY COLUMN estatus
            ENUM('abierto', 'cerrado', 'procesado')
            NOT NULL DEFAULT 'abierto'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE pedidos_globales
            MODIFY COLUMN estatus
            ENUM('abierto', 'cerrado')
            NOT NULL DEFAULT 'abierto'
        ");
    }
};
