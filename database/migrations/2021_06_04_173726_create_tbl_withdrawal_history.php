<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblWithdrawalHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_withdrawal_history', function (Blueprint $table) {
            $table->id('wh_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->decimal('usd', 8, 2)->unsigned()->default('0');
            $table->decimal('epc', 8, 2)->unsigned()->default('0');
            $table->string('epc_address')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('url')->nullable();
            $table->enum('status', ['0', '1','2'],'0 - Request, 1 - Approved, 2- Declined')->default('0');
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
        Schema::dropIfExists('tbl_withdrawal_history');
    }
}
