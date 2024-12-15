<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokalbis', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->time('pradzios_laikas')->nullable();
            $table->unsignedInteger('naudotojo_id');
            $table->unsignedInteger('admin_id');
            $table->timestamps();

            $table->foreign('naudotojo_id')->references('id')->on('users');
            $table->foreign('admin_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokalbis');
    }
};