<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->default(0)->comment('就餐日期');
            $table->string('morning', 500)->comment('早餐');
            $table->string('lunch', 500)->comment('午餐');
            $table->string('dinner', 500)->comment('晚餐');
            $table->timestamp('deleted_at')->default(0);
            $table->index(['date']);
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `recipes` comment '食谱'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
