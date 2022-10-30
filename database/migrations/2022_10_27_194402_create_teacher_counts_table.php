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
        Schema::create('teacher_counts', function (Blueprint $table) {
            $table->id('id_hitung');
            $table->bigInteger('id_guru');
            $table->bigInteger('hadir');
            $table->bigInteger('kegiatan');
            $table->bigInteger('bdr');
            $table->bigInteger('sakit');
            $table->bigInteger('izin');
            $table->bigInteger('nojadwal');
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
        Schema::dropIfExists('teacher_counts');
    }
};
