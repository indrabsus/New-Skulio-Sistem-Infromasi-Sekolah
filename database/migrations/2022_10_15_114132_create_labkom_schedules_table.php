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
        Schema::create('labkom_schedules', function (Blueprint $table) {
            $table->id('id_labkom');
            $table->bigInteger('id_guru');
            $table->bigInteger('id_kelas');
            $table->bigInteger('id_mapel');
            $table->enum('tempat',['a','b','c','d']);
            $table->string('hari');
            $table->bigInteger('jam_a');
            $table->bigInteger('jam_b');
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
        Schema::dropIfExists('labkom_schedules');
    }
};
