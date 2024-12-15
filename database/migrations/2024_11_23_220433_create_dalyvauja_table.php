<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dalyvauja', function (Blueprint $table) {
            $table->unsignedInteger('fk_Pokalbis');
            $table->unsignedInteger('fk_Naudotojas');
            $table->primary(['fk_Pokalbis', 'fk_Naudotojas']);
            $table->foreign('fk_Pokalbis')->references('id')->on('pokalbis');
            $table->foreign('fk_Naudotojas')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dalyvauja');
    }
};