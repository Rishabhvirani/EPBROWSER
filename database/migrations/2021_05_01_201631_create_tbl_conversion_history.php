<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblConversionHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_conversion_history', function (Blueprint $table) {
            $table->id();
            $table->integer('u_id')->unsigned();
            $table->decimal('points', 8, 2);
            $table->decimal('dollar', 8, 2);
            $table->string('conversionRate')->nullable();
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
        Schema::dropIfExists('tbl_conversion_history');
    }
}
