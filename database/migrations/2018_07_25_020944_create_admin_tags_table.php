<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag_name')->comment('标签名称');
            $table->tinyInteger('type')->comment('类型');
            $table->tinyInteger('status')->comment('状态');
            $table->tinyInteger('sort')->comment('排序');
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
        Schema::dropIfExists('admin_tags');
    }
}
