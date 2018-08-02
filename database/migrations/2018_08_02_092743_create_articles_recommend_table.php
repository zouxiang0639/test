<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesRecommendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles_recommend', function (Blueprint $table) {
            $table->integer('articles_id')->comment('文章ID');
            $table->integer('user_id')->comment('用户ID');
            $table->index(['articles_id', 'user_id']);
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `articles_recommend` comment '推荐'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_recommend');
    }
}
