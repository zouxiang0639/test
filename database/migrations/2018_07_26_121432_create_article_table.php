<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('picture')->comment('图片');
            $table->tinyInteger('tag')->default(0)->comment('标签');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->integer('hot')->default(0)->comment('热度');
            $table->text('content')->comment('内容');

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
        Schema::dropIfExists('admin_article');
    }
}
