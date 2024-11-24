<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mokejimas', function (Blueprint $table) {
            $table->increments('mokejimo_id')->primary();
            $table->date('data')->nullable();
            $table->string('apmokejimo_budas')->nullable();
            $table->double('suma')->nullable();
            $table->unsignedInteger('fk_Rezervacija');
            $table->unsignedInteger('fk_Naudotojas');
            $table->foreign('fk_Rezervacija')->references('rezervacijos_id')->on('rezervacija');
            $table->foreign('fk_Naudotojas')->references('kliento_id')->on('naudotojas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mokejimas');
    }
};