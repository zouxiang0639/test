<?php

namespace App\Library\Admin;

use App\Admin\Bls\Auth\MenuBls;
use App\Library\Admin\Consts\StyleTypeConst;
use App\Library\Admin\Widgets\Forms;
use App\Library\Admin\Widgets\NavBar;
use App\Library\Admin\Widgets\Tree;
use Auth;
use App\Admin\Bls\Auth\Model\Menu;
use Collective\Html\HtmlFacade as Form;

class Admin
{
    public $navbar;

    public $js = [StyleTypeConst::FILE => [], StyleTypeConst::CODE => []];

    public $css = [StyleTypeConst::FILE => [], StyleTypeConst::CODE => []];

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

    public function form(\Closure $callback)
    {
        return (new Forms())->form($callback);
    }

    public function tag($tag, $class)
    {

        $tagHtml = [];
        foreach($tag as $value) {

            $tagHtml[] =  Form::tag('span', e($value), ['class' => "label $class", "sta"]);

        }
        return implode('&nbsp;', $tagHtml);
    }

    public function setCss($type, $data)
    {
        switch($type) {
            case StyleTypeConst::FILE:

                $this->css[StyleTypeConst::FILE][] = '<link rel="stylesheet" href="' . assets_path($data) . '">';
                break;

            case StyleTypeConst::CODE:

                $this->css[StyleTypeConst::CODE][] = $data;
                break;

            default:
                break;
        }
    }

    public function setJs($type, $data)
    {
        switch($type) {
            case StyleTypeConst::FILE:

                $this->js[StyleTypeConst::FILE][] = '<script src="' . assets_path($data) . '"></script>';
                break;

            case StyleTypeConst::CODE:

                $this->js[StyleTypeConst::CODE][] = $data;
                break;

            default:
                break;
        }
    }

    public function getCss()
    {
        $file = array_unique($this->css[StyleTypeConst::FILE]);
        $css = '';
        $code = '';
        foreach ($file as $v) {
            $css .= $v;
        }

        foreach($this->css[StyleTypeConst::CODE] as $v) {
            $code .= $v;
        }

        $css .= <<<EOT
        <style>
            $code
        </style>

EOT;
        return $css;
    }

    public function getJs()
    {
        $file = array_unique($this->js[StyleTypeConst::FILE]);
        $js = '';
        $code = '';
        foreach ($file as $v) {
            $js .= $v;
        }

        foreach($this->js[StyleTypeConst::CODE] as $v) {
            $code .= $v;
        }

        $js .= <<<EOT

        <script>
            $(function () {
                $code
            });
        </script>
EOT;
        return $js;
    }

}