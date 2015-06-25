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
            $table->tinyInteger('account_id');
            $table->string('media_id',30)->nullable()->comment('mediaId');
            $table->string('original_id',60)->nullable()->comment('原始微信mediaId');
            $table->tinyInteger('type')->nullable()->default(1)->comment('图文类型 1 单图文 2多图文 3远程素材');
            $table->integer('parent_id')->nullable()->default(0)->comment('父id');
            $table->string('title',200)->comment('标题');
            $table->string('description',360)->nullable()->comment('摘要');
            $table->string('author',24)->nullable()->comment('作者');
            $table->text('content')->nullable()->comment('内容');
            $table->string('cover_media_id')->nullable()->comment('封面 media_id');
            $table->string('cover_url')->nullable()->comment('封面url'); 
            $table->tinyInteger('show_cover_pic')->default(1)->comment('是否显示封面 1 不显示 2 显示');
            $table->tinyInteger('created_from')->nullable()->default(1)->comment('1 来自自己 2来自微信同步');
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
