<?php

namespace App\Consts\Admin\Other;

class FeedbackTypeConst
{
    const ALL = 0;
    const FEEDBACK = 1;
    const OPERATE = 2;
    const MODERATOR = 3;
    const APPEALS = 4;
    const REPORT = 5;

    const ALL_DESC = '全部';
    const FEEDBACK_DESC = '增设板块建议';
    const OPERATE_DESC = '给运营组的建议';
    const MODERATOR_DESC = '版主申请';
    const APPEALS_DESC = '申诉区';
    const REPORT_DESC = '举报';

    public static function desc()
    {
        return [
            self::ALL => self::ALL_DESC,
            self::FEEDBACK => self::FEEDBACK_DESC,
            self::OPERATE => self::OPERATE_DESC,
            self::MODERATOR => self::MODERATOR_DESC,
            self::APPEALS => self::APPEALS_DESC,
            self::REPORT => self::REPORT_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}