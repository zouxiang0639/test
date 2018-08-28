<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('mobile', 11)->unique()->comment('手机号');
            $table->integer('money')->default(0)->comment('余额');
            $table->integer('division')->default(0)->comment('分组');
            $table->tinyInteger('status')->comment('状态 1启用 2禁用 :WhetherConst');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile', 'money', 'division']);
        });
    }
}
