<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('telefono_nr')->nullable();
            $table->string('adresas')->nullable();
            $table->date('registracijos_data')->nullable();
            $table->boolean('ar_administratorius')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};