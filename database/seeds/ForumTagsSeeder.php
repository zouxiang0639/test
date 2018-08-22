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
                'color' => '#d72e2e',
            ],
            [
                'tag_name' => '新闻',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-xinwen',
                'color' => '#24578a',
            ],
            [
                'tag_name' => '幽默',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-youmo',
                'color' => '#4ba155',
            ],
            [
                'tag_name' => '烦恼',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-fannao',
                'color' => '#217d75',
            ],
            [
                'tag_name' => '炫耀',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => ' icon-xuanyao',
                'color' => '#3c7d21',
            ],
            [
                'tag_name' => '宠物',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-chongwu',
                'color' => '#8dc02d',
            ],
            [
                'tag_name' => '美食',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-meishi',
                'color' => '#d78b29',
            ],
            [
                'tag_name' => '影视',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-yingshi',
                'color' => '#d71679',
            ],
            [
                'tag_name' => '音乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-yinyue',
                'color' => '#8d7309',
            ],
            [
                'tag_name' => '游戏',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-youxidongman',
                'color' => '#699769',
            ],
            [
                'tag_name' => '旅游',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-sheyinglvyou',
                'color' => '#e18f68',
            ],
            [
                'tag_name' => '情感',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-qinggan',
                'color' => '#4d9226',
            ],
            [
                'tag_name' => '装扮',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-zhuanban',
                'color' => '#42a4e1',
            ],
            [
                'tag_name' => '体育健身',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-tiyujianshen',
                'color' => '#9f9413',
            ],
            [
                'tag_name' => '明星娱乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'icon-mingxingyule',
                'color' => '#9f481f',
            ],
        ]);
    }
}
