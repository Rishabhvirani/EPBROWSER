<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTimer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_timer', function (Blueprint $table) {
            $table->id('t_id')->unsigned();
            $table->integer('timer')->unsigned();
            $table->decimal('points', 8, 2)->unsigned()->default('0');
            $table->enum('active', ['0', '1'],'0 - Off, 1 - Active,')->default('0');
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
        Schema::dropIfExists('tbl_timer');
    }
}
