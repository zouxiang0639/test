<?php

use Illuminate\Database\Seeder;
use App\Admin\Bls\Other\Model\FeedbackModel;
use App\Consts\Admin\Other\FeedbackTypeConst;
use App\User;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //反馈
        FeedbackModel::truncate();
        FeedbackModel::insert([
            [
                'users_id' => 1,
                'type' => FeedbackTypeConst::FEEDBACK,
                'created_at' => '2018-2-3 12:2:1',
                'extend' => '{"text1": "我是测试1","text2": "我是测试2"}',
                'content' => '晨曦的古巷，清风徐徐，青石板路横斜阡陌。我和先生牵着手，漫步于这条静谧的宽窄巷子，恍惚走于千百年前的蜀国，幽深清静。前面梳着两个麻花辫，穿着白色蕾丝裙子蹦蹦跳跳的女儿，撒下一路欢笑。古色古香的木制老屋商铺沿着青石板路蜿蜒到看不见的路尽头，雕花的两边橱窗里摆着或精致，或可爱，或典雅的丝巾，蜀锦，发钗等商品，琳琅满目。那些透着青光的石板路诉说着古老的历史。我拿着把刺绣小扇，穿着一身柠檬黄丝绸裙，摩梭着脚下的石板，抬头看头顶的四方天，触摸着那些雕花的窗棱，沉浸在这一片安静里。“咔咔”，先生拿着手机拍下了我这沉思的一幕，我给了先生一个回眸一笑。古巷不算长，清晨时，游人或还在沉睡。没有夜晚时的游人如织，摩肩接踵。三两的游人，闲闲散散的缓步于古巷中，仿佛走在回家的路，悠闲自在。或许就是和我们一样，想探索古巷静谧美的人，不习惯那古巷的热闹。我和先生走走走停停，累了，随意街边找了家古茶店坐下，点了两杯菊花茶。先生坐于那端，我坐于这端。女儿隔着绿窗，朝着我们笑。我们时而低语，时而一起看下窗外的蓝天，对街的窗景，时而低头端起杯子喝茶。菊花，味淡而清香，在水里浮沉，在人心里涤荡......阳光渐渐穿过树梢，撒到了青石板路上，印出影影绰绰的树影。游人渐渐多了起来，有拖着行李箱就来的，有三五好友一起的，有一个人慢慢逛的，古巷苏醒了。我们一家，缓缓离开了古巷，留下一个渐行渐远的背影。',
            ]
        ]);

        User::truncate();
        User::insert([
            [
                'name' => '张三',
                'email' => 'admin@qq.com',
                'password' => '$2y$10$9vbGuAlD6rrpz5ULY7uqreZ0uclH.mh92Vfjvb6sbGTJ.Pk3vvs3W',
            ]
        ]);


    }
}
