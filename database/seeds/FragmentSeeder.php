<?php

use Illuminate\Database\Seeder;
use App\Admin\Bls\Other\Model\FragmentModel;

class FragmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //后台配置
        FragmentModel::truncate();
        FragmentModel::insert([
            [
                'title' => '热门描述',
                'contents' => '这里是幽默板块<br>您可以在这里发幽默搞笑类图片、文字，还可以发您觉得有意思的内容<br>其他类型内容请发到相应的板块，否则将删除或自动转移到相应板块',
                'links' => '',
                'picture' => '',
                'created_at' => '2018-07-24',
            ],
            [
                'title' => '最新描述',
                'contents' => '这里是幽默板块<br>您可以在这里发幽默搞笑类图片、文字，还可以发您觉得有意思的内容<br>其他类型内容请发到相应的板块，否则将删除或自动转移到相应板块',
                'links' => '',
                'picture' => '',
                'created_at' => '2018-07-24',
            ],
            [
                'title' => '公告描述',
                'contents' => '这里是幽默板块<br>您可以在这里发幽默搞笑类图片、文字，还可以发您觉得有意思的内容<br>其他类型内容请发到相应的板块，否则将删除或自动转移到相应板块',
                'links' => '',
                'picture' => '',
                'created_at' => '2018-07-24',
            ],
            [
                'title' => '空地社区用户注册协议',
                'contents' => '空地社区用户注册协议',
                'links' => '',
                'picture' => '',
                'created_at' => '2018-07-24',
            ],
            [
                'title' => '积分描述',
                'contents' => '积分描述',
                'links' => '',
                'picture' => '',
                'created_at' => '2018-07-24',
            ],
            [
                'title' => '底部广告咨询',
                'contents' => '广告咨询：info@kongdi.com 2018 kongdi All Rights Reserved',
                'links' => '',
                'picture' => '',
                'created_at' => '2018-07-24',
            ],
        ]);
    }
}
