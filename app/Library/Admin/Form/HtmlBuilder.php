<?php

namespace App\Library\Admin\Form;

use Admin;
use App\Consts\Common\WhetherConst;
use App\Library\Admin\Consts\StyleTypeConst;

class HtmlBuilder extends \Collective\Html\HtmlBuilder
{

    private $resource = [

    ];

    public function createHtmlBuilder()
    {
        return $this;
    }

    private function getResource($name)
    {
        return array_get($this->resource, $name);
    }

}
