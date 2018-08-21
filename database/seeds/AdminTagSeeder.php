<?php

use Illuminate\Database\Seeder;
use App\Admin\Bls\System\Model\TagsModel;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\WhetherConst;

class AdminTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //后台配置
        TagsModel::truncate();
        TagsModel::insert([
            [
                'tag_name' => '公司领导',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '办公室',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '发展建设部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '财务部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '安全监察部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '人力资源部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '党建工作部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '调度控制中心',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '营销部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '运维检修部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '运维站',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '三新公司',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '实业公司',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '工程业务部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '设计咨询部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '物业服务部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '车辆服务部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '腾达电气公司',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '农电服务部',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => '退休',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ]

        ]);
    }
}
