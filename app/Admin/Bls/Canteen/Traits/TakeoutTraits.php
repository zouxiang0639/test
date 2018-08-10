<?php

namespace App\Admin\Bls\Canteen\Traits;


use App\Library\Format\FormatMoney;
use Illuminate\Support\Collection;

trait TakeoutTraits
{

    public function formatTakeout(Collection $items)
    {
        $items->each(function($item) {
            $item->price = FormatMoney::fen2yuan($item->price);
            $item->deposit = FormatMoney::fen2yuan($item->deposit);
        });
    }
}