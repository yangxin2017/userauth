<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('y_auth_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parentid');
            $table->string('name', 300);
            $table->string('desc', 300);
            $table->string('link', 100);
            $table->string('icon', 100);
            $table->boolean('isshow');
            $table->string('auth', 100);
            $table->string('authval', 100);
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
        Schema::dropIfExists('y_auth_menu');
    }
}
