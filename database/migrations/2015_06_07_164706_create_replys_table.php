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
            $table->string('name', 30)->comment('规则名称'); //标题
            $table->string('trigger_texts', 500)->comment('触发文字'); //触发文字
            $table->tinyInteger('trigger_type')->nullable()->default(1)->comment('条件类型'); //默认类型
            $table->string('group_ids')->nullable()->comment('适用范围：组id数组');
            $table->json('content')->comment('触发时返回的内容'); //触发的消息
            $table->timestamps();
            $table->softDeletes();
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
