<?php

use Illuminate\Database\Seeder;
use App\Admin\Bls\System\Model\ConfigModel;

class AdminConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //后台配置
        ConfigModel::truncate();
        ConfigModel::insert([
            [
                'name' => 'title',
                'description' => '网站标题',
                'value' => '空地社区',
            ],
            [
                'name' => 'description',
                'description' => '网站描述',
                'value' => '空地社区',
            ],
            [
                'name' => 'keywords',
                'description' => '网站关键字',
                'value' => '空地社区',
            ],
            [
                'name' => 'icp',
                'description' => '网站备案号',
                'value' => '',
            ],
            [
                'name' => 'default_picture',
                'description' => '默认图片',
                'value' => 'default-picture.png',
            ],
            [
                'name' => 'ico',
                'description' => '浏览器上logo',
                'value' => '',
            ],
            [
                'name' => 'logo',
                'description' => 'logo',
                'value' => 'image/201809/29/cdd9407e9244ad89b4ceb853f2bdfad8.png',
            ],
        ]);

        //论坛设置
        ConfigModel::insert([
            [
                'name' => 'browse',
                'description' => '设置上热门浏览量',
                'value' => '1000',
            ],
            [
                'name' => 'recommend',
                'description' => '设置上热门推荐量',
                'value' => '100',
            ],
            [
                'name' => 'day_article',
                'description' => '当天可发布文章',
                'value' => '10',
            ],

        ]);
    }
}
