<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPengembalianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pengembalian', function (Blueprint $table) {
            $this->down();
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pengembalian_id');
            $table->unsignedBigInteger('buku_id')->nullable();
            $table->enum('keterangan', ['ada', 'hilang']);
            $table->foreign('pengembalian_id', 'fk-pengembalian')->references('id')->on('pengembalian')->onDelete('cascade');
            $table->foreign('buku_id', 'fk-buku')->references('id')->on('buku')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pengembalian');
    }
}
