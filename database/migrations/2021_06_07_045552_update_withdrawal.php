<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWithdrawal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_settings')->where(array(
            'name' => 'isWithdrwalEnabled'
        ))->update(array('label'=>'Withdrawal'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_settings')->where(array('name' => 'isWithdrwalEnabled'))->update(array('label'=>'general'));
    }
}
