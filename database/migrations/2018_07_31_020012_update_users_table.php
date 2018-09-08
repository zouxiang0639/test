<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('login_num')->default(0)->comment('登录次数');
            $table->integer('integral')->default(0)->comment('积分');
            $table->integer('thumbs_up')->default(0)->comment('收到赞数');
            $table->integer('thumbs_down')->default(0)->comment('收到弱数');
            $table->tinyInteger('day_article')->default(0)->comment('当天发布文章');
            $table->timestamp('last_login_time')->default(0)->comment('最后登录时间');
            $table->timestamp('sign_time')->default(0)->comment('签到时间');
            $table->tinyInteger('status')->default(0)->comment('状态  1启用 2禁用 :WhetherConst');
            $table->date('date')->default(0)->comment('禁言日期');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_num', 'integral', 'thumbs_up','day_article', 'last_login_time', 'sign_time']);
        });
    }
}
