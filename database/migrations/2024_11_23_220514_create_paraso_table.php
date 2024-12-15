<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paraso', function (Blueprint $table) {
            $table->unsignedInteger('fk_Naudotojas');
            $table->unsignedInteger('fk_Zinute');
            $table->primary(['fk_Naudotojas', 'fk_Zinute']);
            $table->foreign('fk_Naudotojas')->references('id')->on('users');
            $table->foreign('fk_Zinute')->references('id')->on('zinute');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paraso');
    }
};