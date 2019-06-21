<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'fk-anggota')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama', 50);
            $table->string('kontak')->unique();
            $table->enum('jk', ['L', 'P']);
            $table->enum('agama', ['Islam', 'Kristen', 'Hindu', 'Budha', 'Kongochu']);
            $table->string('alamat', '100');
            $table->enum('status', ['Aktif', 'Pending', 'Block']);
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
        Schema::dropIfExists('anggota');
    }
}
