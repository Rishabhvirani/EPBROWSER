<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertTimers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_timer')->insert(array(
            array('timer' => '1','points' => 1,'active'=>'1'),
            array('timer' => '2','points' => 2,'active'=>'1'),
            array('timer' => '3','points' => 3,'active'=>'1'),
            array('timer' => '4','points' => 4,'active'=>'1'),
            array('timer' => '5','points' => 5,'active'=>'1'),
        ));
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_timer')->truncate();
    }
}
