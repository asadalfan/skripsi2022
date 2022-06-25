<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIsTrueToSawHasilDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saw_hasil_details', function (Blueprint $table) {
            $table->dropColumn('is_true');
            $table->string('answer')->after('soal_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saw_hasil_details', function (Blueprint $table) {
            $table->dropColumn('answer');
            $table->boolean('is_true')->after('soal_id');
        });
    }
}
