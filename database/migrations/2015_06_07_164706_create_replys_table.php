<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');  
            $table->string('name', 30); //标题
            $table->string('trigger_texts',500); //触发文字
            $table->tinyInteger('trigger_type')->nullable()->default(1); //默认类型
            $table->string('content',300); //触发的消息
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('auto_replies');
    }
}
