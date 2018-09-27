<?php

namespace App\Consts\Admin\Other;

class FeedbackReportTypeConst
{
    const ADVERT_MEANINGLESS = 1;
    const INDUCE = 2;
    const UNFRIENDLY = 3;
    const SEXY = 4;
    const OTHER = 5;


    const ADVERT_MEANINGLESS_DESC = '广告或无意义内容';
    const INDUCE_DESC = '无关主题、诱导赞内容';
    const UNFRIENDLY_DESC = '人身攻击、不友善内容';
    const SEXY_DESC = '政治、色情等敏感内容';
    const OTHER_DESC = '其他违规内容';


    public static function desc()
    {
        return [
            self::ADVERT_MEANINGLESS => self::ADVERT_MEANINGLESS_DESC,
            self::INDUCE => self::INDUCE_DESC,
            self::UNFRIENDLY => self::UNFRIENDLY_DESC,
            self::SEXY => self::SEXY_DESC,
            self::OTHER => self::OTHER_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}