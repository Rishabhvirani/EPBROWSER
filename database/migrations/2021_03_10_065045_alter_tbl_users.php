<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTblUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_users', function (Blueprint $table) {
            $table->string('password_reset_token');
            $table->string('device_id');
            $table->string('lat_long');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_users', function (Blueprint $table) {
            $table->dropColumn('password_reset_token');
            $table->dropColumn('device_id');
            $table->dropColumn('lat_long');
        });
    }
}
