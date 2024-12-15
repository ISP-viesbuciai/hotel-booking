<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zinute', function (Blueprint $table) {
            $table->increments('zinutes_id')->primary();
            $table->string('tekstas')->nullable();
            $table->time('laikas')->nullable();
            $table->unsignedInteger('fk_Pokalbis');
            $table->foreign('fk_Pokalbis')->references('pokalbio_id')->on('pokalbis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zinute');
    }
};