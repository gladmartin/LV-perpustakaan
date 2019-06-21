<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('lama_pengembalian');
            $table->unsignedTinyInteger('dispensasi')->nullable();
            $table->unsignedInteger('biaya_denda');
            $table->unsignedBigInteger('petugas_id');
            $table->foreign('petugas_id', 'fk-denda')->references('id')->on('petugas');
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
        Schema::dropIfExists('denda');
    }
}