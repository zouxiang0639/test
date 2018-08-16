<?php
namespace App\Console\Commands;

use App\Canteen\Bls\Users\Model\OrderModel;
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
use Illuminate\Console\Command;

/**
 * Created by RepairSource.
 * @author: zouxiang
 * @date:
 */
class CanteenMeal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canteen:meal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '外卖过期';


    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('开始查询过期的外卖...');
        $model = OrderModel::where('type', OrderTypeConst::MEAL)->where('status', OrderStatusConst::DEPOSIT)->get();

        $model->each(function($item) {
            $model =  $item->orderMeal;
            if($model->date < date('Y-m-d')) {
                $item->status = OrderStatusConst::OVERDUE;
                $item->save();
            }
        });
        $this->line('完成');
    }




}
