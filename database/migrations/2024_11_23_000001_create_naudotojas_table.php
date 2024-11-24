<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('naudotojas', function (Blueprint $table) {
            $table->increments('kliento_id')->primary();
            $table->string('name')->nullable();
            $table->string('password')->nullable();
            $table->string('el_pastas')->nullable();
            $table->string('telefono_nr')->nullable();
            $table->string('adresas')->nullable();
            $table->date('registracijos_data')->nullable();
            $table->boolean('ar_administratorius')->nullable();
            $table->string('prisijungimo_slaptazodis')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('naudotojas');
    }
};