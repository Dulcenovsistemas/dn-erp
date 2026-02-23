<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE remisiones 
            MODIFY estado ENUM('en_proceso','finalizada','cancelada') 
            NOT NULL DEFAULT 'en_proceso'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE remisiones 
            MODIFY estado ENUM('en_proceso','cancelada') 
            NOT NULL DEFAULT 'en_proceso'");
    }

};
