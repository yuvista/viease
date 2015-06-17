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
            $table->tinyInteger('type')->nullable()->default(1);
            $table->integer('parent_id');
            $table->string('title'); //素材标题
            $table->string('description')->nullable(); //描述
            $table->string('author')->nullable();
            $table->text('content');
            $table->string('thumb_media_id'); //
            $table->tinyInteger('show_cover_pic');
            $table->tinyInteger('created_from')->nullable()->default(0);
            $table->tinyInteger('syns_status')->nullable()->default(0);
            $table->string('content_source_url'); //内容连接资源
            $table->string('url')->nullable();
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
