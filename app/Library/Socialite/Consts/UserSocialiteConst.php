<?php
namespace App\Library\Socialite\Consts;

/**
 * 第三方用户
 *
 * Class UserTagConst
 *
 * @package App\Consts\User
 */
class UserSocialiteConst
{
    // 第三方网站类别
    const SOCIALITE_TYPE_WEIXIN_WEB = 1;

    const SOCIALITE_TYPE_QQ = 2;

    const SOCIALITE_TYPE_WEIXIN = 3;

    const SOCIALITE_TYPE_WEIBO = 4;

    // session 登录信息 key
    const SOCIALITE_SESSION_KEY = "LOGIN_SOCIALITE";

    public static function getTypes()
    {
        return [
            self::SOCIALITE_TYPE_WEIXIN_WEB => "微信",
            self::SOCIALITE_TYPE_WEIXIN => "微信",
            self::SOCIALITE_TYPE_QQ => 'QQ',
            self::SOCIALITE_TYPE_WEIBO => '微博',
        ];
    }
    public static function getTypeDesc($type)
    {
        if(empty($type))return '';
        $types=static::getTypes();
        if(isset($types[$type])){
            return $types[$type];
        }
        return "";
    }
    public static function getEname($type = 0)
    {
        $ename = "";
        switch ($type) {
            case self::SOCIALITE_TYPE_WEIXIN_WEB:
                $ename = "weixinweb";
                break;
            case self::SOCIALITE_TYPE_WEIXIN:
                $ename = "weixin";
                break;
            case self::SOCIALITE_TYPE_QQ:
                $ename = "QQ";
                break;
            case self::SOCIALITE_TYPE_WEIBO:
                $ename = "weibo";
                break;
        }
        return $ename;
    }
}