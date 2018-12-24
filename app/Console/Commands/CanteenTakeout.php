<?php
namespace App\Console\Commands;

use App\Canteen\Bls\Users\Model\OrderModel;
use App\Canteen\Bls\Users\Model\OrderTakeoutModel;
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
use Illuminate\Console\Command;

/**
 * Created by RepairSource.
 * @author: zouxiang
 * @date:
 */
class CanteenTakeout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canteen:takeout';

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

        OrderModel::where('status', OrderStatusConst::DEPOSIT)->where('type', OrderTypeConst::TAKEOUT)->update([
            'status' => OrderStatusConst::OVERDUE
        ]);

        $this->line('完成');
    }




}
