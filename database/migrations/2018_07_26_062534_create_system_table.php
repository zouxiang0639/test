<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('配置名称');
            $table->string('value')->comment('配置值');
            $table->text('description')->nullable()->comment('配置描述');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_config` comment '后台配置表'");

        Schema::create('admin_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag_name')->comment('标签名称');
            $table->tinyInteger('type')->comment('类型');
            $table->tinyInteger('status')->comment('状态');
            $table->integer('hot')->default(0)->comment('热度');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id']);
        });
        \DB::statement("ALTER TABLE `admin_tags` comment '标签表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_config');
        Schema::dropIfExists('admin_tags');
    }
}
