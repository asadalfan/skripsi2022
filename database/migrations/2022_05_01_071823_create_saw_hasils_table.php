<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSawHasilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saw_kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->double('bobot');
            $table->timestamps();
        });

        Schema::create('saw_hasils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lamaran_id');
            $table->unsignedBigInteger('saw_kriteria_id');
            $table->double('nilai')->nullable();
            $table->timestamps();

            $table->foreign('lamaran_id')->references('id')->on('lamarans')
                ->onDelete('cascade');
            $table->foreign('saw_kriteria_id')->references('id')->on('saw_kriterias')
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
        Schema::dropIfExists('saw_hasils');
        Schema::dropIfExists('saw_kriterias');
    }
}
