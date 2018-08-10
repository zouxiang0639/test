<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTakeoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('takeout', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->comment('状态 1启用 2关闭 WhetherConst');
            $table->string('title', 100)->comment('标题');
            $table->string('picture', 255)->comment('图片');
            $table->integer('stock')->comment('库存');
            $table->integer('price')->comment('价格');
            $table->integer('deposit')->comment('定金');
            $table->integer('limit')->comment('限购');
            $table->string('describe', 255)->default('')->comment('描述');
            $table->timestamp('deleted_at');
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
        Schema::dropIfExists('takeout');
    }
}
