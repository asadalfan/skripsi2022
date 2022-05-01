<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSawKriteriaIdToSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->unsignedBigInteger('saw_kriteria_id')->after('id')->nullable();

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
        Schema::table('soals', function (Blueprint $table) {
            $table->dropForeign(['saw_kriteria_id']);
            $table->dropColumn('saw_kriteria_id');
            $table->string('type')->after('id')->nullable();
        });
    }
}
