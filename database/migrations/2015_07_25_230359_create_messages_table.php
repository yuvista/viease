<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->integer('fans_id')->comment('粉丝id');
            $table->enum('type', [
                    'text',
                    'image',
                    'shortvideo',
                    'location'
                ])->comment('消息类型 text 文字 image 图片 shortvideo 短视频 location位置');
            $table->timestamp('sent_at')->comment('消息发送时间');
            $table->integer('resource_id')->comment('对应消息资源');
            $table->integer('reply_id')->default(0)->nullable()->comment('消息回复id');
            $table->timestamp('replied_at')->nullable()->comment('消息回复时间');
            $table->json('content');
            $table->string('msg_id',25)->comment('消息id');
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
        Schema::drop('messages');
    }
}
