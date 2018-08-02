<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->comment('父级ID');
            $table->integer('article_id')->comment('文章ID');
            $table->integer('at')->default(0)->comment('@的人');
            $table->integer('issuer')->comment('发布人');
            $table->text('contents')->comment('内容');
            $table->text('thumbs_up')->comment('赞');
            $table->text('thumbs_down')->comment('弱');
            $table->index(['id', 'parent_id', 'article_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reply');
    }
}
