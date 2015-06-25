<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->comment('所属公众号');
            $table->string('media_id',30)->nullable()->comment('mediaId');
            $table->string('original_id',60)->nullable()->comment('原始微信素材id');
            $table->integer('parent_id')->nullable()->default(0)->comment('父id');
            $table->enum('type', ['article','image', 'voice', 'video'])->comment('素材类型');
            $table->tinyInteger('is_multi',1)->nullable()->default(1)->comment('是否是多图文 1 否 2 是'); 
            $table->tinyInteger('is_remote',1)->nullable()->default(1)->comment('是否是远程不可编辑图文 1 是 2 否'); 
            $table->string('title',200)->comment('标题');
            $table->string('description',360)->nullable()->comment('摘要');
            $table->string('author',24)->nullable()->comment('作者');
            $table->text('content')->nullable()->comment('内容');
            $table->string('cover_media_id')->nullable()->comment('封面 media_id');
            $table->string('cover_url')->nullable()->comment('封面url'); 
            $table->tinyInteger('show_cover_pic',1)->default(1)->comment('是否显示封面 1 不显示 2 显示');
            $table->tinyInteger('created_from',1)->nullable()->default(1)->comment('1 微易同步到微信 2自微信同步微易');
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
        Schema::drop('materials');
    }
}
