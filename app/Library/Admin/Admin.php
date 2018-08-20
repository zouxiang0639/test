<?php

namespace App\Library\Admin;

use App\Admin\Bls\Auth\MenuBls;
use App\Library\Admin\Consts\StyleTypeConst;
use App\Library\Admin\Widgets\Advert;
use App\Library\Admin\Widgets\Forms;
use App\Library\Admin\Widgets\Navbar;
use App\Library\Admin\Widgets\Style;
use App\Library\Admin\Widgets\Tree;
use App\Library\Admin\Widgets\Upload;
use Auth;
use App\Admin\Bls\Auth\Model\Menu;
use Collective\Html\HtmlFacade as Form;

class Admin
{
    public $navbar;

    private $style;

    /**
     * Get navbar object.
     *
     * @return \app\Library\Admin\Widgets\NavBar
     */
    public function getNavbar()
    {
        if (is_null($this->navbar)) {
            $this->navbar = new Navbar();
        }
        return $this->navbar;
    }

    /**
     * 上传文件
     * @return Upload
     */
    public function upload()
    {
        return new Upload();
    }

    /**
     * 广告
     * @return Advert
     */
    public function advert()
    {
        return new Advert();
    }

    /**
     * @return Style
     */
    public function style()
    {
        if(empty($this->style)) {
            $this->style = new Style();
        }
        return $this->style;
    }

    /**
     * 获取用户
     * Get current login user.
     *
     * @return mixed
     */
    public function user()
    {
        return Auth::guard('admin')->user();
    }

    /**
     * Left sider-bar menu.
     *
     * @return array
     */
    public function menu()
    {
        return MenuBls::menuTree();
    }

    /**
     * @param  $model
     * @param \Closure $callback
     *
     * @return Tree
     */
    public static function tree($model, \Closure $callback = null)
    {
        return new Tree($model , $callback);
    }

    public function getRouteName()
    {
        return \Request::route()->getName();
    }

    /**
     * form表单
     * @param \Closure $callback
     * @return $this
     */
    public function form(\Closure $callback)
    {
        return (new Forms())->form($callback);
    }
}