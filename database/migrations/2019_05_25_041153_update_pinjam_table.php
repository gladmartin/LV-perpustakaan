<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePinjamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pinjam', function (Blueprint $table) {
            $table->unsignedBigInteger('petugas_id')->nullable();
            $table->foreign('petugas_id', 'fk-pinjam-2')->references('id')->on('petugas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pinjam', function (Blueprint $table) {
            //
        });
    }
}
