<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_settings', function($table) {
            $table->primary('name')->change();
            $table->string('label')->after('value');
            $table->enum('type',['p','c'])->default('p')->after('label');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_settings', function($table) {
            $table->dropPrimary('name')->change();
            $table->dropColumn('label');
            $table->dropColumn('type');
        });
    }
}
