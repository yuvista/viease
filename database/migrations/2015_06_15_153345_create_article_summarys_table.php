<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleSummarysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_summarys', function (Blueprint $table) {
            $table->integer('account_id')->nullable()->comment('所属公众号');
			$table->date('ref_date')->comment('数据的日期');
			$table->integer('ref_hour')->comment('数据的小时');
			$table->date('stat_date')->comment('统计的日期');
			$table->integer('msgid')->comment('由msgid（图文消息id）和index（消息次序索引）组成， 例如12003_3');
			$table->string('title',300)->comment('图文消息的标题');
			$table->integer('int_page_read_user')->comment('图文页（点击群发图文卡片进入的页面）的阅读人数');
			$table->integer('int_page_read_count')->comment('图文页的阅读次数');
			$table->integer('ori_page_read_user')->comment('原文页（点击图文页“阅读原文”进入的页面）的阅读人数，无原文页时此处数据为0');
			$table->integer('ori_page_read_count')->comment('原文页的阅读次数');
			$table->integer('share_scene')->comment('分享的场景:1代表好友转发 2代表朋友圈 3代表腾讯微博 255代表其他');
			$table->integer('share_user')->comment('分享的人数');
			$table->integer('share_count')->comment('分享的次数');
			$table->integer('add_to_fav_user')->comment('收藏的人数');
			$table->integer('add_to_fav_count')->comment('收藏的次数');
			$table->integer('target_user')->comment('送达人数，一般约等于总粉丝数（需排除黑名单或其他异常情况下无法收到消息的粉丝）');
			
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
        Schema::drop('article_summarys');
    }
}
