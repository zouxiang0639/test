<?php

namespace App\Library\Admin;

use App\Library\Admin\Widgets\NavBar;
use Auth;
use App\Bls\Auth\Model\Menu;

class Admin
{
    public $navbar;

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

        return (new Menu())->toTree();
    }
}