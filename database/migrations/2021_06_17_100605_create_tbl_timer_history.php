<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTimerHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_timer_history', function (Blueprint $table) {
            $table->id('th_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('timer_id')->unsigned();
            $table->decimal('points', 8, 2)->unsigned()->default('0');
            // $table->dateTimeTz('start_time', $precision = 0);
            // $table->dateTimeTz('claim_time', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_timer_history');
    }
}
