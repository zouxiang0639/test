<?php

use Illuminate\Database\Seeder;

use App\Consts\Common\WhetherConst;
use App\Admin\Bls\Other\Model\AdvertModel;
use App\Consts\Admin\Other\AdvertTypeConst;
use App\Forum\Bls\Users\Model\UsersModel;
use App\Forum\Bls\Article\Model\ArticleModel;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //广告
        AdvertModel::truncate();
        AdvertModel::insert([
            [
                'type' => AdvertTypeConst::BANNER,
                'status' => WhetherConst::YES,
                'title' => '广告一',
                'picture' => 'image/201808/20/a2036985f2b7bff46154a4d4e96d70df.jpg',
                'links' => 'https://www.baidu.com/',
            ],
            [
                'type' => AdvertTypeConst::REPLY_AD,
                'status' => WhetherConst::YES,
                'title' => '广告二',
                'picture' => 'image/201809/06/4194bb36c1959c4c5eeb761a2e87e888.jpg',
                'links' => 'https://www.baidu.com/',
            ],
            [
                'type' => AdvertTypeConst::SQUARE,
                'status' => WhetherConst::YES,
                'title' => '广告2',
                'picture' => 'image/201808/20/6a2846ddb5e26cbe9c04e3c7b05a58aa.jpg',
                'links' => 'https://www.baidu.com/',
            ],
            [
                'type' => AdvertTypeConst::SQUARE,
                'status' => WhetherConst::YES,
                'title' => '广告3',
                'picture' => 'image/201808/20/3db041fa60c084752e2e23da544fb699.jpg',
                'links' => 'https://www.baidu.com/',
            ],
            [
                'type' => AdvertTypeConst::SQUARE,
                'status' => WhetherConst::YES,
                'title' => '广告4',
                'picture' => 'image/201808/20/8421f3df59bf1655bc52cc35c22b7097.jpg',
                'links' => 'https://www.baidu.com/',
            ],
            [
                'type' => AdvertTypeConst::SQUARE,
                'status' => WhetherConst::YES,
                'title' => '广告5',
                'picture' => 'image/201808/20/e41be4f02d893f4f14e71b017ae323c9.jpg',
                'links' => 'https://www.baidu.com/',
            ],
            [
                'type' => AdvertTypeConst::SQUARE,
                'status' => WhetherConst::YES,
                'title' => '广告6',
                'picture' => 'image/201808/20/6a2846ddb5e26cbe9c04e3c7b05a58aa.jpg',
                'links' => 'https://www.baidu.com/',
            ],
            [
                'type' => AdvertTypeConst::SQUARE,
                'status' => WhetherConst::YES,
                'title' => '广告7',
                'picture' => 'image/201808/20/3db041fa60c084752e2e23da544fb699.jpg',
                'links' => 'https://www.baidu.com/',
            ],
            [
                'type' => AdvertTypeConst::SQUARE,
                'status' => WhetherConst::YES,
                'title' => '广告8',
                'picture' => 'image/201808/20/8421f3df59bf1655bc52cc35c22b7097.jpg',
                'links' => 'https://www.baidu.com/',
            ],
            [
                'type' => AdvertTypeConst::SQUARE,
                'status' => WhetherConst::YES,
                'title' => '广告9',
                'picture' => 'image/201808/20/e41be4f02d893f4f14e71b017ae323c9.jpg',
                'links' => 'https://www.baidu.com/',
            ]
        ]);

        UsersModel::truncate();
        UsersModel::insert([
            [
                'name' => '张三',
                'email' => 'admin@qq.com',
                'password' => '$2y$10$9vbGuAlD6rrpz5ULY7uqreZ0uclH.mh92Vfjvb6sbGTJ.Pk3vvs3W',
            ]
        ]);

        ArticleModel::truncate();
        ArticleModel::insert([
            [
                'title' => '测试数据1',
                'tags' => 9,
                'status' => '1',
                'contents' => '测试数据1',
                'issuer' => 1,
                'ip' => 1,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
            [
                'title' => '测试数据2',
                'tags' => 4,
                'status' => '1',
                'contents' => '测试数据2',
                'issuer' => 1,
                'ip' => 1,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
            [
                'title' => '测试数据3',
                'tags' => '1',
                'status' => '1',
                'contents' => '测试数据2',
                'issuer' => 1,
                'ip' => 1,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
            [
                'title' => '测试数据4',
                'tags' => 5,
                'status' => '1',
                'contents' => '测试数据2',
                'issuer' => 1,
                'ip' => 1,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
            [
                'title' => '测试数据5',
                'tags' => '1',
                'status' => '1',
                'contents' => '测试数据2',
                'issuer' => 1,
                'ip' => 1,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
            [
                'title' => '测试数据6',
                'tags' => '1',
                'status' => '1',
                'contents' => '测试数据2',
                'issuer' => 1,
                'ip' => 5,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
            [
                'title' => '测试数据7',
                'tags' => '1',
                'status' => '1',
                'contents' => '测试数据2',
                'issuer' => 1,
                'ip' => 1,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
            [
                'title' => '测试数据8',
                'tags' => 2,
                'status' => '1',
                'contents' => '测试数据2',
                'issuer' => 1,
                'ip' => 1,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
            [
                'title' => '测试数据9',
                'tags' => 11,
                'status' => '1',
                'contents' => '测试数据2',
                'issuer' => 1,
                'ip' => 7,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
            [
                'title' => '测试数据10',
                'tags' => 11,
                'status' => '1',
                'contents' => '测试数据2',
                'issuer' => 1,
                'ip' => 7,
                'browse' => 1000,
                'recommend' => '[]',
                'thumbs_up' => '[]',
                'thumbs_down' => '[]',
                'star' => '[]',
                'is_hot' => 1,
                'hot_search_time' => '2018-09-13 07:01:02',
            ],
        ]);




    }
}
