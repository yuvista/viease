<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFanSummarysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fan_summarys', function (Blueprint $table) {
            $table->integer('account_id')->nullable()->comment('所属公众号');
			$table->date('ref_date')->comment('数据的日期');
			$table->integer('user_source')->comment('粉丝来源：0代表其他 3代表扫二维码 17代表名片分享 35代表搜号码（即微信添加朋友页的搜索） 39代表查询微信公众帐号 43代表图文页右上角菜单');
			$table->integer('new_user')->comment('新增的粉丝数量');
			$table->integer('cancel_user')->comment('取消关注的粉丝数量，new_user减去cancel_user即为净增粉丝数量 ');
			$table->integer('cumulate_user')->comment('总粉丝数');
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
        Schema::drop('fan_summarys');
    }
}
