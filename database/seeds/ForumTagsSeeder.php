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
                'icon' => 'a-1',
            ],
            [
                'tag_name' => '新闻',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-2',
            ],
            [
                'tag_name' => '幽默',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-3',
            ],
            [
                'tag_name' => '烦恼',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-4',
            ],
            [
                'tag_name' => '炫耀',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-5',
            ],
            [
                'tag_name' => '宠物',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-6',
            ],
            [
                'tag_name' => '美食',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-7',
            ],
            [
                'tag_name' => '影视',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-8',
            ],
            [
                'tag_name' => '音乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-9',
            ],
            [
                'tag_name' => '游戏',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-10',
            ],
            [
                'tag_name' => '旅行',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-11',
            ],
            [
                'tag_name' => '装扮',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-12',
            ],
            [
                'tag_name' => '情感',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-13',
            ],
            [
                'tag_name' => '汽车',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-14',
            ],
            [
                'tag_name' => '摄影',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-15',
            ],
            [
                'tag_name' => '体育',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-16',
            ],
            [
                'tag_name' => '减肥',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-17',
            ],
            [
                'tag_name' => '娱乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-18',
            ],
            [
                'tag_name' => '减肥',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-19',
            ],
            [
                'tag_name' => '娱乐',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
                'icon' => 'a-20',
            ],
        ]);
    }
}
