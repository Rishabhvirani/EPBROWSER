<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserTable00 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_users', function($table) {
            $table->decimal('dollar', 8, 2)->after('points');
            $table->enum('is_active', ['0', '1'],'0 - Active, 1 - Active now')->default('0')->after('status');
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
            $table->dropColumn('dollar');
            $table->dropColumn('is_active');
        });
    }
}
