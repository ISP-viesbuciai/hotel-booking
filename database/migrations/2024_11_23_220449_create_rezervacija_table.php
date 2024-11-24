<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rezervacija', function (Blueprint $table) {
            $table->increments('rezervacijos_id')->primary();
            $table->string('rezervuotu_kambariu_nr')->nullable();
            $table->date('pradzios_data')->nullable();
            $table->date('pabaigos_data')->nullable();
            $table->double('bendra_kaina')->nullable();
            $table->date('sukurimo_data')->nullable();
            $table->integer('kiek_zmoniu')->nullable();
            $table->unsignedInteger('rezervacijos_statusas');
            $table->unsignedInteger('fk_Kambarys');
            $table->unsignedInteger('fk_Naudotojas');
            $table->foreign('fk_Kambarys')->references('kambario_id')->on('kambarys');
            $table->foreign('fk_Naudotojas')->references('kliento_id')->on('naudotojas');
            $table->foreign('rezervacijos_statusas')->references('id_statusas')->on('statusas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rezervacija');
    }
};