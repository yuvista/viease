<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaceSummarysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('face_summarys', function (Blueprint $table) {
            $table->integer('account_id')->nullable()->comment('所属公众号');
			$table->date('ref_date')->comment('数据的日期');
			$table->integer('ref_hour')->comment('数据的小时');
			$table->integer('callback_count')->comment('通过服务器配置地址获得消息后，被动回复用户消息的次数');
			$table->integer('fail_count')->comment('上述动作的失败次数');
			$table->integer('total_time_cost')->comment('总耗时，除以callback_count即为平均耗时');
			$table->integer('max_time_cost')->comment('最大耗时');
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
        Schema::drop('face_summarys');
    }
}
