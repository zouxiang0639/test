<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 190)->unique()->comment('用户名');
            $table->string('password', 60)->comment('密码');
            $table->string('name')->comment('昵称');
            $table->string('avatar')->default('')->comment('头像');
            $table->tinyInteger('status')->comment('状态 :WhetherConst');
            $table->string('remember_token', 100)->default('')->comment('令牌');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_users` comment '后台管理员表'");

        Schema::create('admin_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->comment('名称');
            $table->string('slug', 50)->unique()->comment('标识');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_roles` comment '后台角色表'");

        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->comment('名称');
            $table->string('slug', 50)->unique()->comment('标识');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_permissions` comment '后台权限表'");

        Schema::create('admin_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->comment('父级ID');
            $table->integer('order')->default(0)->comment('排序');
            $table->string('title', 50)->comment('标题');
            $table->string('icon', 50)->comment('图标');
            $table->string('route', 50)->default('')->comment('路由');
            $table->string('slug', 50)->unique()->default('')->comment('标签');
            $table->string('url', 50)->default('')->comment('网站地址');

            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_menu` comment '后台菜单表'");

        Schema::create('admin_role_users', function (Blueprint $table) {
            $table->integer('role_id')->comment('角色ID');
            $table->integer('user_id')->comment('用户ID');
            $table->index(['role_id', 'user_id']);
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_role_users` comment '后台角色与管理员关联表'");

        Schema::create('admin_role_permissions', function (Blueprint $table) {
            $table->integer('role_id')->comment('角色ID');
            $table->integer('permission_id')->comment('权限ID');
            $table->index(['role_id', 'permission_id']);
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_role_permissions` comment '后台角色与权限关联表'");

        Schema::create('admin_user_permissions', function (Blueprint $table) {
            $table->integer('user_id')->comment('用户ID');
            $table->integer('permission_id')->comment('权限ID');
            $table->index(['user_id', 'permission_id']);
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_user_permissions` comment '后台管理员与权限关联表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
        Schema::dropIfExists('admin_roles');
        Schema::dropIfExists('admin_permissions');
        Schema::dropIfExists('admin_menu');
        Schema::dropIfExists('admin_role_users');
        Schema::dropIfExists('admin_role_permissions');
        Schema::dropIfExists('admin_user_permissions');
    }
}
