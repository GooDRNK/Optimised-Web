<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEleviTable extends Migration
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
            $table->integer('idcont');
            $table->char('key',30);    
            $table->char('email',150);
            $table->char('statie',25);

            $table->char('token',60)->nullable();
            
            $table->json('proces')->nullable();
            $table->json('info')->nullable();

            $table->dateTime('last_online')->nullable();
            $table->dateTime('last_login')->nullable();

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
