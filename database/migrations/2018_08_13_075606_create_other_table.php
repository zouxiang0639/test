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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_feedback');
    }
}
