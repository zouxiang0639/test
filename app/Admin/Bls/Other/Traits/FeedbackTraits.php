<?php

namespace App\Admin\Bls\Other\Traits;

use App\Consts\Admin\Other\FeedbackTypeConst;
use Illuminate\Support\Collection;

trait FeedbackTraits
{
    public function formatFeedback(Collection $items)
    {
        $items->each(function($item) {
            $item->typeName = FeedbackTypeConst::getDesc($item->type);
            $item->usersName = '-';
            if($item->users_id != 0 && $users = $item->users)
            {
                $item->usersName = $users->name;
            }
            $item->contentsMb = mb_substr($item->contents, 0 ,50);
        });
    }

}