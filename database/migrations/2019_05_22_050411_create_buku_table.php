<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('isbn', 100);
            $table->unsignedBigInteger('rak_id');            
            $table->foreign('rak_id', 'fk-1')->references('id')->on('rak');
            $table->unsignedBigInteger('pengarang_id');            
            $table->foreign('pengarang_id', 'fk-2')->references('id')->on('pengarang');
            $table->unsignedBigInteger('penerbit_id');            
            $table->foreign('penerbit_id', 'fk-3')->references('id')->on('penerbit');
            $table->unsignedBigInteger('kategori_id');            
            $table->foreign('kategori_id', 'fk-4')->references('id')->on('kategori');
            $table->string('judul', 50);
            $table->text('deskripsi');
            $table->year('tahun_terbit');
            $table->string('cover', 100)->nullable();
            $table->unsignedBigInteger('stok');
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
        Schema::dropIfExists('buku');
    }
}