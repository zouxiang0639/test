<?php

namespace App\Consts\Admin\Customer;

class RechargeTypeConst
{
    const GROUP = 1;
    const ONE = 2;

    const GROUP_DESC = '分组';
    const ONE_DESC = '单个人';

    public static function desc()
    {

        return [
            self::GROUP => self::GROUP_DESC,
            self::ONE => self::ONE_DESC,
        ];
    }

}