<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPoinHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_poin_history', function (Blueprint $table) {
            $table->id('ph_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->decimal('point', 8, 2)->unsigned()->default('0');
            $table->enum('earn_type', ['r', 't'],'r - Referal, 1 - Timer');
            $table->enum('ref_type',['p','c'],'p - parent, c - child')->nullable();
            $table->integer('timer_id')->unsigned()->nullable();
            $table->enum('status', ['0', '1'],'0 - Active, 1 - Deleted')->default('0');
            $table->softDeletes();	
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
        Schema::dropIfExists('tbl_poin_history');
    }

}
