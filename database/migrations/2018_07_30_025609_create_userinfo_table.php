<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('y_userinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->integer('roleid');
            $table->string('openid', 100)->nullable()->default('');
            $table->string('loginname', 100);
            $table->string('nickname', 300);
            $table->string('cellphone', 50);
            $table->string('country', 100)->nullable()->default('');
            $table->string('province', 100)->nullable()->default('');
            $table->string('city', 100)->nullable()->default('');
            $table->tinyInteger('sex')->nullable()->default(1);
            $table->string('avatar', 300)->nullable();
            $table->boolean('isfreeze');
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
        Schema::dropIfExists('y_userinfo');
    }
}
