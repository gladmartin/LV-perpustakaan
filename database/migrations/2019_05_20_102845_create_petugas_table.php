<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'fk-petugas')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama', 50);
            $table->string('kontak')->unique();
            $table->enum('jk', ['L', 'P']);
            $table->enum('agama', ['Islam', 'Kristen', 'Hindu', 'Budha', 'Kongochu']);
            $table->string('alamat', 100);
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
        Schema::dropIfExists('petugas');
    }
}
