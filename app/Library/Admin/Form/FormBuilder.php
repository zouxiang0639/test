<?php

namespace App\Library\Admin\Form;

use Admin;
use App\Consts\Common\WhetherConst;
use App\Library\Admin\Consts\StyleTypeConst;

class FormBuilder extends \Collective\Html\FormBuilder
{

    private $resource = [
        'bootstrap-switch.min.css' => '/lib/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
        'bootstrap-switch.min.js' => '/lib/bootstrap-switch/dist/js/bootstrap-switch.min.js',
        'fileinput.min.css' => '/lib/bootstrap-fileinput/css/fileinput.min.css?v=4.3.7',
        'fileinput.min.js' => '/lib/bootstrap-fileinput/js/fileinput.min.js?v=4.3.7',
        'canvas-to-blob.min.js' => '/lib/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js?v=4.3.7',
        'jquery.inputmask.bundle.min.js' => '/lib/AdminLTE/plugins/input-mask/jquery.inputmask.bundle.min.js',
        'fontawesome-iconpicker.min.css' => '/lib/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css',
        'fontawesome-iconpicker.min.js' => '/lib/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js',
        'bootstrap-duallistbox.min.css' => '/lib/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css',
        'bootstrap-duallistbox.min.js' => '/lib/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js',
        'select2.full.min.js' => '/lib/AdminLTE/plugins/select2/select2.full.min.js',
        'select2.min.css' => '/lib/AdminLTE/plugins/select2/select2.min.css',
    ];

    public function createFormBuilder()
    {
        return $this;
    }

    private function getResource($name)
    {
        return array_get($this->resource, $name);
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

        Admin::setCss(StyleTypeConst::FILE, $this->getResource('select2.min.css'));
        Admin::setJs(StyleTypeConst::FILE, $this->getResource('select2.full.min.js'));

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

        Admin::setCss(StyleTypeConst::FILE, $this->getResource('select2.min.css'));
        Admin::setJs(StyleTypeConst::FILE, $this->getResource('select2.full.min.js'));

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

        Admin::setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-duallistbox.min.css'));
        Admin::setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-duallistbox.min.js'));

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

        Admin::setCss(StyleTypeConst::FILE, $this->getResource('fontawesome-iconpicker.min.css'));
        Admin::setJs(StyleTypeConst::FILE, $this->getResource('fontawesome-iconpicker.min.js'));

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
        Admin::setJs(StyleTypeConst::FILE, $this->getResource('jquery.inputmask.bundle.min.js'));

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

    /**
     * 创建一个上传单个文件
     * @param $name
     * @param null $value
     * @param array $options
     * @return string
     */
    public function imageOne($name, $value = null, $options = [])
    {
        $path = $value ? uploads_path($value) : $value;
        $options['data-initial-preview'] = $path;
        $options['data-initial-caption'] = $value;
        Admin::setCss(StyleTypeConst::FILE, $this->getResource('fileinput.min.css'));
        Admin::setJs(StyleTypeConst::FILE, $this->getResource('fileinput.min.js'));
        Admin::setJs(StyleTypeConst::FILE, $this->getResource('canvas-to-blob.min.js'));

        $route = route('m.system.upload.image');
        $code = <<<EOT

            $("input[name=$name]").fileinput({
                "showRemove": false,
                theme: "explorer",
                uploadUrl: "$route",
                "browseLabel": "浏览",
                minFileCount: 1,
                maxFileCount: 2,
                overwriteInitial: false,
                showUpload: false,
                initialPreviewAsData: true,
                allowedFileExtensions: ['jpg', 'png', 'gif'],
                msgInvalidFileExtension: '文件 "{name}". 扩展名无效, 只支持 "{extensions}" 扩展名',
                uploadExtraData: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "_method": "PUT",
                    "name": "$name"
                },
                preferIconicPreview: true
            }).on("filebatchselected", function(event, files) {
                if(files['length'] > 0) {
                    $(this).fileinput("upload");
                }
            }).on("fileuploaded", function(event, data) {
                if(data.response) {
                    $(this).fileinput("reset");
                    $(this).fileinput("cancel");

                    $('.kv-upload-progress').hide();
                    $('.$name .file-preview-image').attr('src',data.response.data.url);
                    $(".$name").find('input[name=$name]').val(data.response.data.filePath)
                }
            });\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);

        return self::hidden($name, $value).self::file($name, $options);
    }

    public function switchOff($name,  $value = WhetherConst::NO)
    {

        Admin::setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-switch.min.css'));
        Admin::setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-switch.min.js'));
        $code = <<<EOT
           $(".$name .switch").bootstrapSwitch({
                size:'small',
                onText: 'YES',
                offText: 'NO',
                onColor: 'primary',
                offColor: 'default',
                onSwitchChange: function(event, state) {
                    $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '2').change();
                }
            })\n
EOT;
        Admin::setJs(StyleTypeConst::CODE, $code);
        $checked = $value == WhetherConst::YES ? 'checked' : '';
        return self::checkbox('', '', '',  ['class' => 'switch la_checkbox', $checked]).self::hidden($name, $value);

    }
}
