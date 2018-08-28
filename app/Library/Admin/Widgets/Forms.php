<?php

namespace App\Library\Admin\Widgets;

use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use Illuminate\Support\Collection;
use Form;

/**
 * Class Form.
 */
class Forms
{

    public $date;
    public $open = [];

    /**
     * @var FormBuilder
     */
    public $form;

    public $formHtml = '';
    public $helpBlock = '';

    public function __construct()
    {
        $this->date = Collection::make();
        $this->form = Form::createFormBuilder();
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function form(\Closure $callback)
    {
        $callback($this);
        return $this;
    }

    public function create($title, \Closure $callback){
        $html = new HtmlFormTpl();
        $html->title = $title;
        $callback($html, $this->form);
        $this->date->push($html);

    }

    /**
     * 设置表单元素
     * @param $item
     * @return string
     */
    private function formGroup($item)
    {
        if($item->input) {
            $required = $this->getRequired($item->required);
            $getHelpBlock = $this->getHelpBlock($item->helpBlock);
            $id = $this->getId($item->id);

            return <<<EOT

            <div class="form-group" $id>
                <label for="username" class="col-sm-2 control-label">
                    $required
                    $item->title:
                </label>
                <div class="col-sm-7 $item->name">
                    <div class="input-group" style="width:100%">
                     $item->input

                     </div>
                      $getHelpBlock
                </div>
            </div>
EOT;
        }
    }

    /**
     * 获取form表单
     * @return string
     */
    public function getFormHtml()
    {
        $open = array_merge(['class'=> 'form-horizontal box-body fields-group'], $this->open);
        $this->formHtml .=  Form::open($open);

        $this->date->each(function($item) {
            $this->formHtml .= $this->formGroup($item);
        });

        $id = array_get($open,'submit_id', 'form-submit');
        $this->formHtml .= <<<EOT
        <div class="box-footer">
            <a class="btn btn-info col-md-offset-2 {$id}" data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">
                提交
            </a>
        </div>
EOT;
        $this->formHtml .=  Form::close();
        return $this->formHtml;
    }


    /**
     * 获取说明
     * @param $helpBlock
     * @return string
     */
    public function getHelpBlock($helpBlock)
    {
        if(empty($helpBlock)) {
            return '';
        }

        return <<<EOT

            <span class="help-block">
                <i class="fa fa-info-circle"></i>&nbsp;$helpBlock
            </span>
EOT;

    }

    /**
     * 获取必须标记
     * @param $required
     * @return string
     */
    public function getRequired($required)
    {
        if(empty($required)) {
            return '';
        }

        return <<<EOT

           <span class="text-danger">*</span>
EOT;

    }

    public function getId($id)
    {
        if(empty($id)) {
            return '';
        }

        return "id='$id'";
    }

}