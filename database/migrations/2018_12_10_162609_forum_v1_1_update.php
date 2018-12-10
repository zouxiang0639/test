<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 论坛v1.1 添加字段
 * Created by ForumV11Update.
 * @author: zouxiang
 * @date:
 */
class ForumV11Update extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //公告
        Schema::table('notice', function (Blueprint $table) {
            $table->tinyInteger('is_home')->default(0)->comment('推荐首页');
        });

        //回复
        Schema::table('reply', function (Blueprint $table) {
            $table->string('ip')->comment('IP地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notice', function (Blueprint $table) {
            $table->dropColumn(['is_home']);
        });
        Schema::table('reply', function (Blueprint $table) {
            $table->dropColumn(['ip']);
        });
    }
}
