<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokalbis', function (Blueprint $table) {
            $table->increments('pokalbio_id')->primary();
            $table->time('pradzios_laikas')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokalbis');
    }
};