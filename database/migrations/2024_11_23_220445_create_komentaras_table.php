<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komentaras', function (Blueprint $table) {
            $table->increments('komentaro_id');
            $table->string('tekstas')->nullable();
            $table->date('data')->nullable();
            $table->unsignedInteger('likes_count')->default(0);

            $table->unsignedInteger('fk_Atsiliepimas');
            $table->unsignedInteger('fk_Naudotojas')->nullable();

            $table->foreign('fk_Atsiliepimas')->references('atsiliepimo_id')->on('atsiliepimas');
            $table->foreign('fk_Naudotojas')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komentaras');
    }
};