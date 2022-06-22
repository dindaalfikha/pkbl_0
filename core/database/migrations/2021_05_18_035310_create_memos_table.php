<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('memo');
            $table->date('tgl_memo');
            $table->text('persetujuan');
            $table->date('tgl_persetujuan');
            $table->text('kontrak');
            $table->date('tgl_kontrak');
            $table->integer('rencana_penyaluran');
            $table->integer('realisasi_penyaluran');
            $table->date('mulai_angsuran');
            $table->date('berakhir_angsuran');
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
        Schema::dropIfExists('memos');
    }
}
