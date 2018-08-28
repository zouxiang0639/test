<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->integer('amount')->comment('总金额 分');
            $table->integer('deposit')->comment('定金 分');
            $table->tinyInteger('status')->comment('状态 1已支付定金 2全额支付  4完成 5退单 OrderStatusConst');
            $table->tinyInteger('type')->comment('类型 1点餐 2外卖 OrderTypeConst');
            $table->integer('payment')->comment('已支付金额');
            $table->timestamp('payment_at')->nullable()->comment('已支付时间');
            $table->timestamps();
            $table->index(['user_id']);
        });
        \DB::statement("ALTER TABLE `order` comment '订单'");

        Schema::create('order_takeout', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('takeout_id')->comment('外卖ID');
            $table->integer('order_id')->comment('订单ID');
            $table->string('name', 100)->comment('外卖名称');
            $table->integer('price')->comment('价格 分');
            $table->integer('deposit')->comment('定金 分');
            $table->integer('num')->comment('数量');
            $table->tinyInteger('is_weigh')->comment('是否称重 1是 2否 WhetherConst');
            $table->timestamps();
            $table->index(['order_id', 'takeout_id']);
        });
        \DB::statement("ALTER TABLE `order_takeout` comment '外卖订单关联'");

        Schema::create('account_flow', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->tinyInteger('type')->comment('状态 1支付 2充值 3对冲 AccountFlowType');
            $table->integer('amount')->comment('金额');
            $table->string('describe', 255)->default('')->comment('描述');
            $table->integer('hedging_id')->default(0)->comment('对冲ID');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `account_flow` comment '账户流水'");


        Schema::create('order_meal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recipes_id')->comment('食谱ID');
            $table->integer('order_id')->comment('订单ID');
            $table->integer('price')->comment('价格 分');
            $table->integer('num')->comment('数量');
            $table->integer('discount')->comment('折扣');
            $table->date('date')->comment('就餐日期');
            $table->tinyInteger('type')->comment('类型 1早餐 2午餐 3晚餐 MealTypeConst');
            $table->timestamps();
            $table->index(['order_id', 'recipes_id']);
        });
        \DB::statement("ALTER TABLE `order_meal` comment '外卖订单关联'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_takeout');
        Schema::dropIfExists('account_flow');
        Schema::dropIfExists('order_meal');
    }
}
