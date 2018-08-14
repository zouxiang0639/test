<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->default(0)->comment('用户ID');
            $table->tinyInteger('type')->comment('类型 FeedbackTypeConst');
            $table->text('extend')->comment('扩展属性');
            $table->text('contents')->comment('内容');
            $table->timestamps();
            $table->index(['users_id']);
        });
        \DB::statement("ALTER TABLE `admin_feedback` comment '客户反馈'");

     /*   Schema::create('admin_advert', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->comment('类型 AdvertTypeConst');
            $table->tinyInteger('status')->comment('状态 1启用 2禁用 :WhetherConst');
            $table->integer('hot')->default(0)->comment('热度');
            $table->string('title', 100)->comment('标题');
            $table->string('picture', 255)->comment('图片');
            $table->string('links', 150)->default('')->comment('链接');
            $table->string('comment', 255)->default('')->comment('描述');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_advert` comment '广告'");*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_feedback');
        /*Schema::dropIfExists('admin_advert');*/
    }
}
