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
                'icon' => 'icon-xianliao',
            ],
            [
                'tag_name' => '新闻',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-xinwen',
            ],
            [
                'tag_name' => '幽默',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-youmo',
            ],
            [
                'tag_name' => '烦恼',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-fannao',
            ],
            [
                'tag_name' => '炫耀',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => ' icon-xuanyao',
            ],
            [
                'tag_name' => '宠物',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-chongwu',
            ],
            [
                'tag_name' => '美食',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-meishi',
            ],
            [
                'tag_name' => '影视',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-yingshi',
            ],
            [
                'tag_name' => '音乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-yinyue',
            ],
            [
                'tag_name' => '游戏',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-youxidongman',
            ],
            [
                'tag_name' => '旅游',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-sheyinglvyou',
            ],
            [
                'tag_name' => '情感',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-qinggan',
            ],
            [
                'tag_name' => '装扮',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-zhuanban',
            ],
            [
                'tag_name' => '体育健身',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-tiyujianshen',
            ],
            [
                'tag_name' => '明星娱乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-mingxingyule',
            ],
        ]);
    }
}
