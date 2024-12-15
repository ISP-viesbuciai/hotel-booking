<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atsiliepimas', function (Blueprint $table) {
            $table->increments('atsiliepimo_id')->primary();
            $table->string('tekstas')->nullable();
            $table->integer('ivertinimas')->nullable();
            $table->date('data')->nullable();
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('fk_Naudotojas');
            $table->foreign('fk_Naudotojas')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atsiliepimas');
        Schema::table('atsiliepimas', function (Blueprint $table) {
            $table->dropColumn('likes_count');
        });
    }
};
