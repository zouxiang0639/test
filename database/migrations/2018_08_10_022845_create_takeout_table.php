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
            $table->string('title', 100)->comment('标题');
            $table->string('picture', 255)->comment('图片');
            $table->integer('stock')->comment('库存');
            $table->integer('price')->comment('价格');
            $table->integer('deposit')->comment('定金');
            $table->integer('limit')->comment('限购');
            $table->date('start_time')->comment('起售时间');
            $table->date('end_time')->comment('截止时间');
            $table->string('describe', 255)->comment('描述');
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
