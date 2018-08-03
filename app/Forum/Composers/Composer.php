<?php
namespace App\Forum\Composers;

use Illuminate\Support\Facades\View;

/**
 * Composer服务提供类
 *
 */
class Composer
{
    public static function boot()
    {
        View::composer('forum::partials.member_info', 'App\Forum\Composers\MemberComposer');
    }
}
