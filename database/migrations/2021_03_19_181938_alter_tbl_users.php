<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTblUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_users', function($table) {
            $table->string('ref_code', 25)->change();
            $table->string('username', 25)->change();            
            $table->string('email',60)->change();
        });
        
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_users', function($table) {
            $table->string('ref_code', 15)->change(); 
            $table->string('username', 40)->change();            
            $table->string('email',50)->change();
        });
    }
}
