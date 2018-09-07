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
    public $helpBlock = '';
    public $id = '';

    /**
     * @param string $name
     * @param string $required
     * @param string $helpBlock
     * @return $this
     */
    public function set($name = '', $required = '', $helpBlock = '')
    {
        $this->name = $name;
        $this->required = $required;
        $this->helpBlock = $helpBlock;
    }
}