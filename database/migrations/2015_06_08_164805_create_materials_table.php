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
            $table->enum('type', ['image', 'voice', 'video'])->comment('素材类型');
            $table->string('original_id',60)->nullable()->comment('原始微信mediaId');   
            $table->string('url');
            $table->string('title')->nullable()->comment('视频标题');
            $table->string('description')->nullable()->comment('视频描述');
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
