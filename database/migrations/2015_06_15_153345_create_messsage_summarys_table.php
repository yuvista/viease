<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesssageSummarysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messsage_summarys', function (Blueprint $table) {
            $table->integer('account_id')->nullable()->comment('所属公众号');
			$table->date('ref_date')->comment('数据的日期');
			$table->integer('ref_hour')->comment('数据的小时');
			$table->integer('msg_type')->comment('消息类型，代表含义如下：1代表文字 2代表图片 3代表语音 4代表视频 6代表第三方应用消息（链接消息）');
			$table->integer('msg_user')->comment('上行发送了（向公众号发送了）消息的用户数');
			$table->integer('msg_count')->comment('上行发送了消息的消息总数');
			$table->integer('count_interval')->comment('当日发送消息量分布的区间，0代表 “0”，1代表“1-5”，2代表“6-10”，3代表“10次以上”');
			$table->integer('int_page_read_count')->comment('图文页的阅读次数');
			$table->integer('ori_page_read_user')->comment('原文页（点击图文页“阅读原文”进入的页面）的阅读人数，无原文页时此处数据为0');
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
        Schema::drop('messsage_summarys');
    }
}
