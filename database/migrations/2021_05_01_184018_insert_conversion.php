<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertConversion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_settings')->insert(array(
            array('name' => 'isConversionEnabled','value' => false,'type'=>'p','label'=>'conversion'),
            array('name' => 'ConversionRate','value' => 0,'type'=>'c','label'=>'conversion'),
            array('name' => 'MinConversion','value' => 1000,'type'=>'c','label'=>'conversion'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_settings')->where('label','conversion')->delete();
    }
}
