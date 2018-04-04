<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elevi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('statie');
            $table->string('pass');
            $table->dateTime('date_add');
            $table->json('tools')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_logout')->nullable();
            $table->integer('idcont');
            $table->char('token',60)->nullable();
            $table->string('email');
            $table->dateTime('lastonline')->nullable();
            $table->json('openweb')->nullable();
            $table->json('sistemoptonly')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elevi');
    }
}
