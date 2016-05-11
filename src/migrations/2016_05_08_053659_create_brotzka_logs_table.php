<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrotzkaLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brotzka_databaselogger_logs', function(Blueprint $t){
            $t->increments('id');
            $t->string('level');
            $t->string('text');
            $t->mediumText('message');
            $t->tinyInteger('read');
            $t->tinyInteger('fixed');
            $t->softDeletes();
            $t->timestamps();
        });
        
        Schema::create('brotzka_databaselogger_logcomments', function(Blueprint $t){
            $t->increments('id');
            $t->integer('log_id');
            $t->string('title');
            $t->mediumText('text');
            $t->smallInteger('user_id');
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("brotzka_databaselogger_logs");
        Schema::drop('brotzka_databaselogger_logcomments');
    }
}
