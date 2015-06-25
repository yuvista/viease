<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          /**
           * 备注防止忘记
           * addon 插件中的事件 article 图文 text 回复文字 material 素材 动作 已经在菜单中实现
           */
          Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->string('key',128)->comment('事件名称');
            $table->enum('type', ['addon','article','text','material'])->comment('事件类型');
            $table->string('content',600)->comment('事件触发的内容,自动回复的字数而定'); 
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
        Schema::drop('events');
    }
}
