<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertReferalSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_settings')->insert(array(
            array('name' => 'isReferalActive','value' => false,'type'=>'p','label'=>'referal'),
            array('name' => 'parentEarning','value' => 0,'type'=>'c','label'=>'referal'),
            array('name' => 'childEarning','value' => 0,'type'=>'c','label'=>'referal'),
            array('name' => 'earningType','value' => 'bonus','type'=>'c','label'=>'referal'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_settings')->where('label','referal')->delete();
    }
}
