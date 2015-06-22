<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->tinyInteger('type')->nullable()->default(0)->comment('图文类型 0 单图文 1多图文');
            $table->integer('parent_id')->nullable()->default(0)->comment('父id');
            $table->string('title')->comment('标题');
            $table->string('digest')->nullable()->comment('描述');
            $table->string('author')->nullable()->comment('作者');
            $table->text('content')->nullable()->comment('内容');
            $table->string('thumb_media_id')->nullable()->comment('缩略图id'); 
            $table->tinyInteger('show_cover')->comment('是否显示封面 0 不显示 1 显示');
            $table->tinyInteger('created_from')->nullable()->default(0)->comment('0 来自自己 1来自微信同步');
            $table->string('source_url')->nullable()->comment('内容连接资源'); 
            $table->string('content_url')->nullable()->comment('原文链接');
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
        Schema::drop('articles');
    }
}
