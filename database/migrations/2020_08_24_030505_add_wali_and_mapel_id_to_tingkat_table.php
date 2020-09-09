<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaliAndMapelIdToTingkatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tingkat', function (Blueprint $table) {
            $table->foreignId('guru_id')->after('nama');
            $table->string('mapel_id',255)->after('guru_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tingkat', function (Blueprint $table) {
            //
        });
    }
}
