<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertWithdrawalSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_settings')->insert(array(
            array('name' => 'epc_rate','value' => 0.1,'type'=>'c','label'=>'Withdrawal'),
            array('name' => 'MinWithdrawal','value' => 10,'type'=>'c','label'=>'Withdrawal'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::table('tbl_settings')->where('name','epc_rate')->delete();
        DB::table('tbl_settings')->where('name','MinWithdrawal')->delete();
    }
}
