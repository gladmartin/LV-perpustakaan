<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinjamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('anggota_id');
            $table->foreign('anggota_id','fk-borrow-1')->references('id')->on('anggota')->onDelete('cascade');
            $table->unsignedBigInteger('denda_id');
            $table->foreign('denda_id','fk-borrow-2')->references('id')->on('denda');
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan']);
            $table->timestamp('tgl_pinjam');
            $table->timestamp('tgl_dikembalikan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pinjam');
    }
}