<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesStarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles_star', function (Blueprint $table) {
            $table->integer('articles_id')->comment('文章ID');
            $table->integer('user_id')->comment('用户ID');
            $table->index(['articles_id', 'user_id']);
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `articles_star` comment '收藏表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_star');
    }
}
