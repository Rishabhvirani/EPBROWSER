<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertAdsSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbl_settings')->insert(array(
            array('name' => 'appId','value' => '','type'=>'c','label'=>'ads'),
            array('name' => 'isBannerAdActive','value' => false,'type'=>'p','label'=>'ads'),
            array('name' => 'isInterstitialAdActive','value' => false,'type'=>'p','label'=>'ads'),
            array('name' => 'isOpenAdActive','value' => false,'type'=>'p','label'=>'ads'),
            array('name' => 'bannerAdId','value' => '','type'=>'c','label'=>'ads'),
            array('name' => 'interstitialAdId','value' => '','type'=>'c','label'=>'ads'),
            array('name' => 'interstitialAdSetting','value' => '','type'=>'c','label'=>'ads'),
            array('name' => 'OpenAdId','value' => '','type'=>'c','label'=>'ads'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tbl_settings')->where('label','ads')->delete();
    }
}
