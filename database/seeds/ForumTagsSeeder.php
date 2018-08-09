<?php

use Illuminate\Database\Seeder;
use App\Admin\Bls\System\Model\TagsModel;
use App\Consts\Common\WhetherConst;
use App\Consts\Admin\Tags\TagsTypeConst;

class ForumTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TagsModel::truncate();
        TagsModel::insert([
            [
                'tag_name' => '闲聊',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon1.png',
                'icon2' => '/forum/icon1.png',
            ],
            [
                'tag_name' => '新闻',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon2.png',
                'icon2' => '/forum/icon2_1.png',
            ],
            [
                'tag_name' => '幽默',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon3.png',
                'icon2' => '/forum/icon3_1.png',
            ],
            [
                'tag_name' => '烦恼',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon4.png',
                'icon2' => '/forum/icon4_1.png',
            ],
            [
                'tag_name' => '炫耀',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon5.png',
                'icon2' => '/forum/icon5_1.png',
            ],
            [
                'tag_name' => '宠物',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon6.png',
                'icon2' => '/forum/icon6_1.png',
            ],
            [
                'tag_name' => '美食',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon7.png',
                'icon2' => '/forum/icon7_1.png',
            ],
            [
                'tag_name' => '影视',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon8.png',
                'icon2' => '/forum/icon8_1.png',
            ],
            [
                'tag_name' => '音乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon9.png',
                'icon2' => '/forum/icon9_1.png',
            ],
            [
                'tag_name' => '游戏',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon10.png',
                'icon2' => '/forum/icon10_1.png',
            ],
            [
                'tag_name' => '旅行',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon11.png',
                'icon2' => '/forum/icon11_1.png',
            ],
            [
                'tag_name' => '装扮',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon12.png',
                'icon2' => '/forum/icon12_1.png',
            ],
            [
                'tag_name' => '情感',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon13.png',
                'icon2' => '/forum/icon13_1.png',
            ],
            [
                'tag_name' => '汽车',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon14.png',
                'icon2' => '/forum/icon14_1.png',
            ],
            [
                'tag_name' => '摄影',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon15.png',
                'icon2' => '/forum/icon15_1.png',
            ],
            [
                'tag_name' => '体育',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon16.png',
                'icon2' => '/forum/icon16_1.png',
            ],
            [
                'tag_name' => '娱乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon17.png',
                'icon2' => '/forum/icon17_1.png',
            ],
            [
                'tag_name' => '减肥',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon18.png',
                'icon2' => '/forum/icon18_1.png',
            ],
            [
                'tag_name' => '娱乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => '/forum/icon19.png',
                'icon2' => '/forum/icon19_1.png',
            ]
        ]);
    }
}
