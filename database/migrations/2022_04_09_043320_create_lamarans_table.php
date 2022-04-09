<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLamaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lamarans', function (Blueprint $table) {
            $table->increments();
            $table->unsignedBigInteger('pelamar_id');
            $table->unsignedBigInteger('pekerjaan_id');
            
            $table->timestamps();

            $table->foreign('pelamar_id')->references('id')->on('pelamars')
                ->onDelete('cascade');
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lamarans');
    }
}
