<?php

namespace App\Library\Admin\Form;

use Collective\Html\HtmlBuilder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;


class HtmlFormTpl
{
    public $options = ['class'=>'form-control'];
    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $title = '';

    /**
     * @var string
     */
    public $required = '';

    /**
     * @var string
     */
    public $input = '';

    /**
     * @param string $name
     * @param string $required
     * @return $this
     */
    public function set($name = '', $required = '')
    {
        $this->name = $name;
        $this->required = $required;
    }
}