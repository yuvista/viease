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
            $table->string('name', 60)->comment('公众号名称');
            $table->string('original_id',20)->comment('原始id');
            $table->string('app_id',50)->nullable();
            $table->string('app_secret',50)->nullable();
            $table->string('wechat_account',20)->comment('微信号');
            $table->string('access_token',30)->nullable();
            $table->tinyInteger('account_type')->nullable()->default(1)->comment('类型');
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
        Schema::drop('accounts');
    }
}
