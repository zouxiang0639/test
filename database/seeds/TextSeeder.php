<?php

use Illuminate\Database\Seeder;
use App\Admin\Bls\Canteen\Model\TakeoutModel;
use App\Canteen\Bls\Users\Model\UsersModel;

class TextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //后台配置
        TakeoutModel::truncate();
        TakeoutModel::insert([
            [
                'status' => 1,
                'title' => '包子',
                'picture' => 'image/201808/10/1cf8d6dec11212e07fdba2e44d9b96ef.jpg',
                'stock' => 100,
                'price' => 300,
                'deposit' => 100,
                'limit' => 5,
                'describe' => '一份包子一个',
            ],
            [
                'status' => 1,
                'title' => '馒头',
                'picture' => 'image/201808/10/1cf8d6dec11212e07fdba2e44d9b96ef.jpg',
                'stock' => 100,
                'price' => 200,
                'deposit' => 50,
                'limit' => 3,
                'describe' => '一份馒头3个',
            ],
            [
                'status' => 1,
                'title' => '牛肉',
                'picture' => 'image/201808/10/1cf8d6dec11212e07fdba2e44d9b96ef.jpg',
                'stock' => 100,
                'price' => 1000,
                'deposit' => 500,
                'limit' => 1,
                'describe' => '一份牛肉半斤',
            ],
            [
                'status' => 1,
                'title' => '榨菜',
                'picture' => 'image/201808/10/1cf8d6dec11212e07fdba2e44d9b96ef.jpg',
                'stock' => 100,
                'price' => 500,
                'deposit' => 200,
                'limit' => 2,
                'describe' => '一份榨菜5包`',
            ],
        ]);
        UsersModel::truncate();
        UsersModel::insert([
            [
                'name' => '张三',
                'password' => '$2y$10$9vbGuAlD6rrpz5ULY7uqreZ0uclH.mh92Vfjvb6sbGTJ.Pk3vvs3W',
                'mobile' => '13816720691',
                'money' => '100000',
            ]
        ]);

    }
}
