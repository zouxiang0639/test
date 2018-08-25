<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_tags', function (Blueprint $table) {
            $table->string('icon', 255)->default('')->comment('图标');
            $table->string('color', 50)->default('')->comment('图标颜色');
            $table->string('contents', 600)->default('')->comment('内容');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_tags', function (Blueprint $table) {
            $table->dropColumn(['icon','color','contents']);
        });
    }
}
