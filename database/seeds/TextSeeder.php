<?php

use App\Admin\Bls\Canteen\Model\TakeoutModel;
use App\Canteen\Bls\Users\Model\UsersModel;
use App\Admin\Bls\Canteen\Model\RecipesModel;
use App\Consts\Common\WhetherConst;

class TextSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Run the datebase seeds.
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
                'is_weigh' => 2,
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
                'is_weigh' => 2,
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
                'is_weigh' => 1,
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
                'is_weigh' => 2,
            ],
        ]);

        RecipesModel::truncate();
        RecipesModel::insert([
            [
               'date' => '2018-09-04',
               'morning' => "小龙虾\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'lunch' => "小番茄\r\n 红烧狮子头\r\n 一大碗水饺\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'dinner' => "变态辣番茄\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 小龙虾\r\n"
            ],
            [
               'date' => '2018-09-05',
               'morning' => "小龙虾\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'lunch' => "小番茄\r\n 红烧狮子头\r\n 一大碗水饺\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'dinner' => "变态辣番茄\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 小龙虾\r\n"
            ],
            [
               'date' => '2018-09-06',
               'morning' => "小龙虾\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'lunch' => "小番茄\r\n 红烧狮子头\r\n 一大碗水饺\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'dinner' => "变态辣番茄\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 小龙虾\r\n"
            ],
            [
               'date' => '2018-09-07',
               'morning' => "小龙虾\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'lunch' => "小番茄\r\n 红烧狮子头\r\n 一大碗水饺\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'dinner' => "变态辣番茄\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 小龙虾\r\n"
            ],
            [
               'date' => '2018-09-08',
               'morning' => "小龙虾\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'lunch' => "小番茄\r\n 红烧狮子头\r\n 一大碗水饺\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'dinner' => "变态辣番茄\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 小龙虾\r\n"
            ],
            [
               'date' => '2018-09-09',
               'morning' => "小龙虾\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'lunch' => "小番茄\r\n 红烧狮子头\r\n 一大碗水饺\r\n 特大号汉堡\r\n 变态辣番茄\r\n",
               'dinner' => "变态辣番茄\r\n 红烧狮子头\r\n 一大碗拉面\r\n 特大号汉堡\r\n 小龙虾\r\n"
            ]
        ]);


        UsersModel::truncate();
        UsersModel::insert([
            [
                'name' => '张三',
                'password' => '$2y$10$9vbGuAlD6rrpz5ULY7uqreZ0uclH.mh92Vfjvb6sbGTJ.Pk3vvs3W',
                'mobile' => '13816720691',
                'money' => '100000',
                'email' => '542506511@qq.com',
                'status' => WhetherConst::YES,
                'division' => 1,
            ],
            [
                'name' => '李四',
                'password' => '$2y$10$9vbGuAlD6rrpz5ULY7uqreZ0uclH.mh92Vfjvb6sbGTJ.Pk3vvs3W',
                'mobile' => '12312341234',
                'money' => '100000',
                'email' => '542506511@qq.com',
                'status' => WhetherConst::YES,
                'division' => 1,
            ]
        ]);

    }
}
