<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60); //公众号名称
            $table->string('original_id',20); //原始id
            $table->string('app_id',50)->nullable();
            $table->string('app_secret',50)->nullable();
            $table->string('wechat_account',20);
            $table->string('token',30)->nullable();
            $table->tinyInteger('account_type')->nullable()->default(1); //类型
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accounts');
    }
}
