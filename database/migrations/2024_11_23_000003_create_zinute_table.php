<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zinute', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string('tekstas')->nullable();
            $table->time('laikas')->nullable();
            $table->unsignedInteger('pokalbio_id');
            $table->unsignedInteger('siuntejo_id');
            $table->unsignedInteger('gavejo_id');

            $table->foreign('pokalbio_id')->references('id')->on('pokalbis');
            $table->foreign('siuntejo_id')->references('id')->on('users');
            $table->foreign('gavejo_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zinute');
    }
};