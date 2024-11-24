<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kambarys', function (Blueprint $table) {
            $table->increments('kambario_id')->primary();
            $table->integer('kambario_nr')->nullable();
            $table->boolean('available')->nullable();
            $table->string('tipas')->nullable();
            $table->integer('capacity')->nullable();
            $table->double('kaina_nakciai')->nullable();
            $table->boolean('vaizdas_i_jura')->nullable();
            $table->integer('aukstas')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kambarys');
    }
};