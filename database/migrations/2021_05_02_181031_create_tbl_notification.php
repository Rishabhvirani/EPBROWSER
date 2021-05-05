<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_notification', function (Blueprint $table) {
            $table->Integer('n_id',20)->unsigned();
            $table->integer('sender')->unsigned()->nullable();
            $table->integer('receiver')->unsigned()->nullable();
            $table->enum('n_type', ['r','c','t','w','g'],'r-referal,c-conversion,t-timer,w-withdrawal,g-general');
            $table->enum('ref_type',['p','c'],'p - parent, c - child')->nullable();
            $table->decimal('points', 8, 2)->nullable();
            $table->decimal('usd', 8, 2)->nullable();
            $table->decimal('coins', 8, 2)->nullable();
            $table->integer('timer')->unsigned()->nullable();
            $table->integer('data')->unsigned()->nullable();
            $table->enum('is_read', ['0', '1'],'0-unseen,1-seen')->default('0');
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
        Schema::dropIfExists('tbl_notification');
    }
}
