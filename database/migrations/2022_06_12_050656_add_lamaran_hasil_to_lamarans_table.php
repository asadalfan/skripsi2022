<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLamaranHasilToLamaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            // Verifikasi
            $table->boolean('diverifikasi')->default(0);
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable();
            $table->string('catatan_diverifikasi')->nullable();

            $table->foreign('diverifikasi_oleh')->references('id')->on('users')
                ->onDelete('cascade');

            // Terima
            $table->boolean('diterima')->default(0);
            $table->timestamp('diterima_pada')->nullable();
            $table->unsignedBigInteger('diterima_oleh')->nullable();
            $table->string('alasan_diterima')->nullable();

            $table->foreign('diterima_oleh')->references('id')->on('users')
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
        Schema::table('lamarans', function (Blueprint $table) {
            // Verifikasi
            $table->dropForeign(['diverifikasi_oleh']);
            $table->dropColumn('diverifikasi_oleh');
            $table->dropColumn('diverifikasi');
            $table->dropColumn('diverifikasi_pada');
            $table->dropColumn('catatan_diverifikasi');

            // Terima
            $table->dropForeign(['diterima_oleh']);
            $table->dropColumn('diterima_oleh');
            $table->dropColumn('diterima');
            $table->dropColumn('diterima_pada');
            $table->dropColumn('alasan_diterima');
        });
    }
}
