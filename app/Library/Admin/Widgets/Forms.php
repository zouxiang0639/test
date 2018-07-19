<?php

namespace App\Library\Admin\Widgets;

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
    public $form;
    public $formHtml = '';

    public function __construct()
    {
        $this->date = Collection::make();
        $this->form = Form::createFormBuilder();
    }

    public function form(\Closure $callback)
    {
        $callback($this);
        return $this;
    }

    public function create($title, \Closure $callback){
        $html = new HtmlFormTpl();
        $html->title = $title;
        $callback($html);
        $this->date->push($html);

    }

    private function formGroup($item)
    {
        if($item->input) {
            $required = $item->required === true ? '<span class="text-danger">*</span>' : '';
            return <<<EOT

            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">
                    $required
                    $item->title:
                </label>
                <div class="col-sm-7 $item->name">
                    <div class="input-group" style="width:100%">
                     $item->input
                     </div>
                </div>
            </div>
EOT;
        }
    }

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
            <a id='$id'  class="btn btn-info col-md-offset-2" data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">
                提交
            </a>
        </div>
EOT;
        $this->formHtml .=  Form::close();
        return $this->formHtml;
    }

}