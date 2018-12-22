<?php
namespace App\Library\Socialite\Consts;

class ResultConst
{
    // 成功
    const SUCCESS = 1;
    // 错误
    const ERROR = - 500;
    // 更新失败
    const UPDATE_FAILED = - 801;
    // 删除失败
    const DELETE_FAILED = - 802;
    // 添加失败
    const ADD_FAILED = - 803;
    
    // 用户未找到
    const USER_NOT_FOUND = - 10001;
    // 缺少用户id
    const USER_UID_LOST_PARAM = - 10002;
    // 用户已经设置了第三方来源
    const USER_HAS_SET_SOCIALITE_TYPE = - 10003;
    // 用户名为空
    const USER_NAME_EMPTY = - 10004;
    // 用户名不唯一
    const USER_NAME_NOT_UNIQUE = - 10005;

    /**
     * -第三方登录-
     */
    // 第三方用户未找到
    const USER_SOCIALITE_NOT_FOUND = - 10011;
    // 第三方用户和系统用户已经绑定了
    const USER_SOCIALITE_HAS_BOUND = - 10012;
    // 缺少第三方网站的用户id
    const USER_SOCIALITE_UID_LOST_PARAM = - 10013;
    // 缺少第三方用户类型
    const USER_SOCIALITE_TYPE_LOST_PARAM = - 10014;
    // 非第三方账户拥有人解绑
    const USER_SOCIALITE_NOT_OWNER_UNBOUND = - 10015;
    // 第三方账户还未绑定
    const USER_SOCIALITE_HASNOT_BOUND = - 10016;
    // 第三方账户网站已经绑定过了
    const USER_SOCIALITE_SITE_HAS_BOUND = - 10017;
    // 没有登录的第三方用户信息
    const USER_SOCIALITE_HAS_NOT_LOGIN_IDS = - 10018;
    // 第三方账户拥有人和用户不是同一人
    const USER_SOCIALITE_NOT_SAME = - 10019;
    // 获取第三方用户信息错误
    const USER_SOCIALITE_REQUIRE_USER_ERROR = - 10020;
    // 缺少第三方用户信息
    const USER_SOCIALITE_LOST_USER_ERROR = - 10021;
    // 是禁止用户
    const USER_UNABLE = - 10023;

    public static function getDesc($code)
    {
        switch ($code) {
            case self::SUCCESS:
                return "请求成功";
            case self::ERROR:
                return "请求错误";
            case self::UPDATE_FAILED:
                return "更新失败";
            case self::DELETE_FAILED:
                return "删除失败";
            case self::ADD_FAILED:
                return "添加失败";
            
            case self::USER_NOT_FOUND:
                return "用户未找到";
            case self::USER_UID_LOST_PARAM:
                return "缺少用户id";
            case self::USER_HAS_SET_SOCIALITE_TYPE:
                return "用户已经设置了第三方来源";
            case self::USER_NAME_EMPTY:
                return "用户名为空";
            case self::USER_NAME_NOT_UNIQUE:
                return "用户名不唯一";
            case self::USER_UNABLE:
                return "用户已被禁止";
            
            /**
             * -第三方登录-
             */
            case self::USER_SOCIALITE_NOT_FOUND:
                return "第三方用户未找到";
            case self::USER_SOCIALITE_HAS_BOUND:
                return "已被其他账户绑定，请先解绑";
            case self::USER_SOCIALITE_UID_LOST_PARAM:
                return "缺少第三方网站的用户id";
            case self::USER_SOCIALITE_TYPE_LOST_PARAM:
                return "缺少第三方用户类型";
            case self::USER_SOCIALITE_NOT_OWNER_UNBOUND:
                return "非第三方账户拥有人解绑";
            case self::USER_SOCIALITE_HASNOT_BOUND:
                return "第三方账户还未绑定";
            case self::USER_SOCIALITE_SITE_HAS_BOUND:
                return "用户已绑定过这个第三方网站的账户，不能再绑定其他账户";
            case self::USER_SOCIALITE_HAS_NOT_LOGIN_IDS:
                return "没有登录的第三方用户信息";
            case self::USER_SOCIALITE_NOT_SAME:
                return "第三方账户拥有人和用户不是同一人";
            case self::USER_SOCIALITE_REQUIRE_USER_ERROR:
                return "获取第三方用户信息错误";
            case self::USER_SOCIALITE_LOST_USER_ERROR:
                return "缺少第三方用户信息";
        }
        return "";
    }
}