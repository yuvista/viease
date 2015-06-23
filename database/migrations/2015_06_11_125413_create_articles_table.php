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
            $table->string('title',200)->comment('标题');
            $table->string('description',360)->nullable()->comment('摘要');
            $table->string('author',24)->nullable()->comment('作者');
            $table->text('content')->nullable()->comment('内容');
            $table->string('cover')->nullable()->comment('当为远程素材时 这里是url 当非远程素材时这里为MediaId'); 
            $table->tinyInteger('show_cover')->default(1)->comment('是否显示封面 0 不显示 1 显示');
            $table->tinyInteger('is_remote')->comment('是否是远程的素材,当获取菜单中临时素材时保存的数据');
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
