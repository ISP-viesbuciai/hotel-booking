<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mokejimo_informacija', function (Blueprint $table) {
            $table->increments('MokejimoInformacijos_id')->primary();
            $table->string('Korteles_nr')->nullable();
            $table->string('Korteles_savininkas')->nullable();
            $table->date('Galiojimo_data')->nullable();
            $table->string('CVV')->nullable();
            $table->string('Atsiskaitymo_adresas')->nullable();
            $table->unsignedInteger('fk_Mokejimas');
            $table->foreign('fk_Mokejimas')->references('mokejimo_id')->on('mokejimas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mokejimo_informacija');
    }
};