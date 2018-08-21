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
                'tag_name' => 'A组',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => 'B组',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],
            [
                'tag_name' => 'C组',
                'type' => TagsTypeConst::TAG,
                'status' => WhetherConst::YES,
            ],

        ]);
    }
}
