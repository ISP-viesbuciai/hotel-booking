<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('el_laiskas', function (Blueprint $table) {
            $table->increments('laisko_id')->primary();
            $table->string('siuntejo_el_pastas')->nullable();
            $table->string('gavejo_el_pastas')->nullable();
            $table->string('tema')->nullable();
            $table->string('tekstas')->nullable();
            $table->time('laikas')->nullable();
            $table->unsignedInteger('fk_Naudotojas');
            $table->foreign('fk_Naudotojas')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('el_laiskas');
    }
};