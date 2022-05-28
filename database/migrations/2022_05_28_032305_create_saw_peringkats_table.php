<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSawPeringkatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saw_peringkats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lamaran_id');
            $table->double('nilai')->nullable();
            $table->string('nilai_fuzzy')->nullable();
            $table->timestamps();

            $table->foreign('lamaran_id')->references('id')->on('lamarans')
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
        Schema::dropIfExists('saw_peringkats');
    }
}
