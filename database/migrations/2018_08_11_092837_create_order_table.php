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
            $table->integer('user_id')->comment('用户ID');
            $table->string('title', 100)->comment('订单名称');
            $table->integer('amount')->comment('总金额 分');
            $table->integer('deposit')->comment('定金 分');
            $table->tinyInteger('status')->comment('状态 1已支付定金 2全额支付 3待评价 4完成 OrderStatus');
            $table->increments('id');
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
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `account_flow` comment '账户流水'");
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
    }
}
