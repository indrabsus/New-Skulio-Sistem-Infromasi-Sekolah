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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('npsn');
            $table->string('notel');
            $table->string('email');
            $table->string('fb');
            $table->string('ig');
            $table->string('yt');
            $table->string('logo');
            $table->string('nama_sekolah');
            $table->string('desk_singkat');
            $table->string('desk_panjang');
            $table->string('alamat');
            $table->string('url');
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
        Schema::dropIfExists('profiles');
    }
};
