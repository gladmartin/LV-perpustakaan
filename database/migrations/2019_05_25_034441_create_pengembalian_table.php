<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengembalianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pinjam_id');
            $table->unsignedBigInteger('petugas_id')->nullable();
            $table->timestamp('tgl_pengembalian');
            $table->foreign('pinjam_id', 'fkpengembalian1')->references('id')->on('pinjam')->onDelete('cascade');
            $table->foreign('petugas_id', 'fkpengembalian2')->references('id')->on('petugas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalian');
    }
}
