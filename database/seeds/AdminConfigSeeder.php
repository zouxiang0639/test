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
                'value' => '',
            ],
            [
                'name' => 'description',
                'description' => '网站描述',
                'value' => '',
            ],
            [
                'name' => 'keywords',
                'description' => '网站关键字',
                'value' => '',
            ],
            [
                'name' => 'icp',
                'description' => '网站备案号',
                'value' => '',
            ],
            [
                'name' => 'default_picture',
                'description' => '默认图片',
                'value' => '',
            ],
            [
                'name' => 'ico',
                'description' => '浏览器上logo',
                'value' => '',
            ],
        ]);
    }
}
