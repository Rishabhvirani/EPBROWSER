<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->id('u_id')->unsigned();
            $table->string('username', 25)->unique();
            $table->string('email',40)->unique();
            $table->string('password');
            $table->string('mobile')->unique();
            $table->text('profile_photo_path')->nullable();
            $table->rememberToken();
            $table->string('verification_code')->unique();
            $table->enum('email_verified', ['0', '1'],'0 - Not Verified, 1 - Verified')->default('0');
            $table->enum('mobile_verified', ['0', '1'],'0 - Not Verified, 1 - Verified')->default('0');
            $table->enum('user_banned', ['0', '1'],'0 - Active, 1 - banned')->default('0');
            $table->string('coin_address')->unique();
            $table->decimal('points', 8, 2);
            $table->decimal('coins', 8, 2);
            $table->integer('ref_id')->unsigned()->nullable();
            $table->string('ref_code', 15)->unique()->nullable();
            $table->string('country', 4)->nullable();
            $table->string('api_token',90);
            $table->integer('lat',false, true)->length(30)->nullable();
            $table->integer('long',false, true)->length(30)->nullable();
            $table->string('device_id',35)->nullable();
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
        Schema::dropIfExists('tbl_users');
    }
}
