<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeraturanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peraturan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('lama_pengembalian');
            $table->tinyInteger('maksimal_peminjaman');
            $table->tinyInteger('dispensasi_keterlambatan');
            $table->float('biaya_denda');
            $table->unsignedBigInteger('petugas_id');
            $table->enum('status', ['aktif', 'non-aktif']);
            $table->foreign('petugas_id', 'fk-peraturan')->references('id')->on('petugas');
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
        Schema::dropIfExists('peraturan');
    }
}
