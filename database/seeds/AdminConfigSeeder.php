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
                'value' => '食堂管理系统',
            ],
            [
                'name' => 'description',
                'description' => '网站描述',
                'value' => '食堂管理系统',
            ],
            [
                'name' => 'keywords',
                'description' => '网站关键字',
                'value' => '食堂管理系统',
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
                'value' => '',
            ],
        ]);

        ConfigModel::insert([
            [
                'name' => 'takeout_deadline',
                'description' => '外卖截止时间',
                'value' => '2018-08-20',
            ],
            [
                'name' => 'refund_limit',
                'description' => '限制退单',
                'value' => '2',
            ],
            [
                'name' => 'morning_price',
                'description' => '早餐费',
                'value' => '500',
            ],
            [
                'name' => 'lunch_price',
                'description' => '午餐费',
                'value' => '2000',
            ],
            [
                'name' => 'dinner_price',
                'description' => '晚餐费',
                'value' => '2000',
            ],
            [
                'name' => 'meal_deadline',
                'description' => '截止预定时间',
                'value' => '17:00',
            ]
        ]);
    }

}
