<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komentaras', function (Blueprint $table) {
            $table->increments('komentaro_id')->primary();
            $table->string('tekstas')->nullable();
            $table->date('data')->nullable();
            $table->unsignedInteger('fk_Atsiliepimas');
            $table->foreign('fk_Atsiliepimas')->references('atsiliepimo_id')->on('atsiliepimas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komentaras');
    }
};