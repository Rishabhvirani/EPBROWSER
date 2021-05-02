<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertGeneralSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_settings')->insert(array(
            array('name' => 'isNotificationEnabled','value' => false,'type'=>'p','label'=>'general'),
            array('name' => 'isWithdrwalEnabled','value' => false,'type'=>'p','label'=>'general'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_settings')->where('name','isNotificationEnabled')->delete();
        DB::table('tbl_settings')->where('name','isWithdrwalEnabled')->delete();
    }
}
