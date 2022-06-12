<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSawHasilDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saw_hasil_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saw_hasil_id');
            $table->unsignedBigInteger('soal_id');
            $table->boolean('is_true')->default(0);
            $table->timestamps();

            $table->foreign('saw_hasil_id')->references('id')->on('saw_hasils')
                ->onDelete('cascade');
            $table->foreign('soal_id')->references('id')->on('soals')
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
        Schema::dropIfExists('saw_hasil_details');
    }
}
