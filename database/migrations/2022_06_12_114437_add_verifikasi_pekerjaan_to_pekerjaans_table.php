<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifikasiPekerjaanToPekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->boolean('diverifikasi')->default(0);
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable();
            $table->string('catatan_diverifikasi')->nullable();

            $table->foreign('diverifikasi_oleh')->references('id')->on('users')
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
        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->dropForeign(['diverifikasi_oleh']);
            $table->dropColumn('diverifikasi_oleh');
            $table->dropColumn('diverifikasi');
            $table->dropColumn('diverifikasi_pada');
            $table->dropColumn('catatan_diverifikasi');
        });
    }
}
