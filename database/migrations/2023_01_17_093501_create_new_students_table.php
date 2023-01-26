<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_students', function (Blueprint $table) {
            $table->id('id_ppdb');
            $table->bigInteger('nisn')->unique();
            $table->string('nama');
            $table->enum('jenkel', ['l', 'p']);
            $table->string('asal_sekolah');
            $table->string('minat');
            $table->enum('bayar',['n','y']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_students');
    }
};
