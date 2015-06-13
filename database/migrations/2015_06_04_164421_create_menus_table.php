<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');     //所属公众号
            $table->integer('parent_id')->nullable()->default(0);//菜单父id 默认0
            $table->string('name', 30);        //菜单的名称
            $table->string('type', 30);        //菜单类型
            $table->string('key', 200);        //实际值
            $table->tinyInteger('sort')->nullable()->default(0); //排序默认0
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
