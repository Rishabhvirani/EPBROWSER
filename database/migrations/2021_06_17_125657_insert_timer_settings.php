<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertTimerSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_settings')->insert(array(
            array('name' => 'isTimerActive','value' => '0','type'=>'c','label'=>'general'),
            array('name' => 'TimerParentEarning','value' => '0','type'=>'c','label'=>'general'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_settings')->where('name','isTimerActive')->delete();
        DB::table('tbl_settings')->where('name','TimerParentEarning')->delete();
    }
}
