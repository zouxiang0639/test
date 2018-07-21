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


    /**
     * 展示数据
     * @param $data
     * @return \Illuminate\Support\HtmlString
     */
    public function display($data)
    {
        if($data) {
           return $this->html->tag('div', e($data), ['class' => 'box box-body  box-solid box-default no-margin']);
        }
    }

    /**
     * Create a multipleSelect box field.
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
                placeholder: "$name",
                separator:true
            });\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);
        $selectAttributes = array_merge(["multiple"=>"multiple",'data-placeholder'=>"请输入"], $selectAttributes);
        return self::hidden(str_replace(array("[","]"),"",$name)).
        self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
    }
    /**
     * Create a select2 box field.
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
    public function select2(
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
                placeholder: "$name",
                separator:true
            });\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);
        $selectAttributes = array_merge(['data-placeholder'=>"请输入"], $selectAttributes);
        return self::hidden(str_replace(array("[","]"),"",$name)).
        self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
    }

    /**
     * Create a dualListBox field.
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
    public function dualListBox(
        $name,
        $list = [],
        $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ) {

        Admin::setCss(StyleTypeConst::FILE, '/lib/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css');
        Admin::setJs(StyleTypeConst::FILE, '/lib/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js');

        $code = <<<EOT

            $("select[name='$name']").bootstrapDualListbox({
                "filterTextClear":"显示全部",
                "filterPlaceHolder":"过滤",
                "infoText" : "总共 {0} 项",
                "infoTextFiltered" : '{0} / {1}',
                "infoTextEmpty": "空列表",
            });\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);

        $selectAttributes = array_merge(["multiple"=>"multiple",'data-placeholder'=>"请输入"], $selectAttributes);
        return self::hidden(str_replace(array("[","]"),"",$name)).
        self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
    }

    /**
     * Create a icon input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function icon($name, $value = null, $options = [])
    {

        Admin::setCss(StyleTypeConst::FILE, '/lib/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css');
        Admin::setJs(StyleTypeConst::FILE, '/lib/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js');

        $code = <<<EOT
           $("input[name=$name]").iconpicker({placement:'bottomLeft'});\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);
        return $this->html->tag('span', '', ['class' => 'input-group-addon'])
               . self::text($name, $value ?:'fa-bars', $options);
    }

    /**
     * 创建一个货币text
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function currency($name, $value = null, $options = [])
    {
        Admin::setJs(StyleTypeConst::FILE, '/lib/AdminLTE/plugins/input-mask/jquery.inputmask.bundle.min.js');

        $code = <<<EOT
           $("input[name=$name]").inputmask({
               "alias":"currency",
               "autoGroup": !0,
               "placeholder": "0",
               "prefix":"",
               "removeMaskOnSubmit":true

           });\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);
        return $this->html->tag('span', '$', ['class' => 'input-group-addon'])
        . self::text($name, $value , $options);
    }
}
