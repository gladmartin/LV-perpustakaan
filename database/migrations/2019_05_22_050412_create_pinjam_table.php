<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPinjamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pinjam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pinjam_id');
            $table->foreign('pinjam_id', 'fk-detail_pinjam-1')->references('id')->on('pinjam');
            $table->unsignedBigInteger('buku_id');
            $table->foreign('buku_id', 'fk-detail_pinjam-2')->references('id')->on('buku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pinjam');
    }
}
