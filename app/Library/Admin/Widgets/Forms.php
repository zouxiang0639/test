<?php

namespace App\Library\Admin\Widgets;

use Illuminate\Support\Collection;
use Form;

/**
 * Class Form.
 */
class Forms
{

    public $date;

    public $form;

    public $formHtml = '';
    public $options = ['class'=>'form-control'];

    public function __construct()
    {
        $this->date = Collection::make();
        $this->form = Form::createFormBuilder();
    }

    public function form(\Closure $callback, $open)
    {
        $callback($this);
        $open = array_merge(['class'=> 'form-horizontal box-body fields-group'], $open);
        $this->formHtml .=  Form::open($open);

        $this->date->each(function($item) {

            list($title, $name, $required, $input) = $item;
            $this->formHtml .= $this->formGroup($title, $name, $required, $input);

        });

        $id = array_get($open,'submit_id', 'form-submit');
        $this->formHtml .= <<<EOT
        <div class="box-footer">
            <a id='$id'  class="btn btn-info col-md-offset-2" data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">
                提交
            </a>
        </div>
EOT;
        $this->formHtml .=  Form::close();
        return $this->formHtml;
    }

    private function formGroup($title, $name, $required, $input)
    {

        $required = $required === true ? '<span class="text-danger">*</span>' : '';
        return <<<EOT

        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">
                $required
                $title:
            </label>
            <div class="col-sm-7 $name">
                <div class="input-group" style="width:100%">
                 $input
                 </div>
            </div>
        </div>
EOT;
    }


}