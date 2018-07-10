<?php

namespace App\Library\Admin\Form;

use Admin;
use App\Library\Admin\Consts\StyleTypeConst;

class FormBuilder extends \Collective\Html\FormBuilder
{

    public function createFormBuilder()
    {
        return $this;
    }

    public function text($name, $value = null, $options = [])
    {
        return $this->iconLabel('fa-pencil') .
                parent::text($name, $value, $options);
    }

    public function password($name, $options = [])
    {
        return $this->iconLabel('fa-eye-slash') .
        parent::password($name, $options);
    }

    public function iconLabel($icon)
    {
        return '<span class="input-group-addon"><i class="fa fa-fw ' . $icon . '"></i></span>';
    }

    /**
     * Create a select box field.
     *
     * @param  string $name
     * @param  array  $list
     * @param  string|bool $selected
     * @param  array  $selectAttributes
     * @param  array  $optionsAttributes
     * @param  array  $optgroupsAttributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function multipleSelect(
        $name,
        $list = [],
        $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ) {

        Admin::setCss(StyleTypeConst::FILE, '/lib/AdminLTE/plugins/select2/select2.min.css');
        Admin::setJs(StyleTypeConst::FILE, '/lib/AdminLTE/plugins/select2/select2.full.min.js');

        $code = <<<EOT

            $("select[name='$name']").select2({
                allowClear: true,
                placeholder: "$name"
            });\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);

        $selectAttributes = array_merge(["multiple"=>"multiple",'data-placeholder'=>"请输入"], $selectAttributes);
        return self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes)
            . self::hidden($name);
    }
}
