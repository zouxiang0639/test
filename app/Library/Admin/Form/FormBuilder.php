<?php

namespace App\Library\Admin\Form;

use Admin;
use App\Consts\Common\WhetherConst;
use App\Library\Admin\Consts\StyleTypeConst;

class FormBuilder extends \Collective\Html\FormBuilder
{

    private $resource = [
        //开关
        'bootstrap-switch.min.css' => '/lib/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
        'bootstrap-switch.min.js' => '/lib/bootstrap-switch/dist/js/bootstrap-switch.min.js',

        //上传文件
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

        //编辑器
        'ckeditor.js' => '/lib/ckeditor/ckeditor.js',

        //日期
        'bootstrap-datetimepicker.min.css' =>'/lib/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        'moment-with-locales.min.js' =>'/lib/moment/min/moment-with-locales.min.js',
        'bootstrap-datetimepicker.min.js' =>'/lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',

        //数字输入
        'bootstrap-number-input.js' =>'/lib/bootstrap-number/bootstrap-number-input.js',

        //颜色
        'bootstrap-colorpicker.min.css' =>'/lib/AdminLTE/plugins/colorpicker/bootstrap-colorpicker.min.css',
        'bootstrap-colorpicker.min.js' =>'/lib/AdminLTE/plugins/colorpicker/bootstrap-colorpicker.min.js'
    ];

    /**
     * @return $this
     */
    public function createFormBuilder()
    {
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
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

        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('select2.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('select2.full.min.js'));

        $code = <<<EOT

            $("select[name='$name']").select2({
                allowClear: true,
                placeholder: "$name",
                separator:true
            });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
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

        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('select2.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('select2.full.min.js'));

        $code = <<<EOT

            $("select[name='$name']").select2({
                allowClear: true,
                placeholder: "$name",
                separator:true
            });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        $selectAttributes = array_merge(['data-placeholder'=>"请输入",'placeholder'=>'请输入'], $selectAttributes);
        return self::select($name ,$list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
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

        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-duallistbox.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-duallistbox.min.js'));

        $code = <<<EOT

            $("select[name='$name']").bootstrapDualListbox({
                "filterTextClear":"显示全部",
                "filterPlaceHolder":"过滤",
                "infoText" : "总共 {0} 项",
                "infoTextFiltered" : '{0} / {1}',
                "infoTextEmpty": "空列表",
            });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);

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

        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('fontawesome-iconpicker.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('fontawesome-iconpicker.min.js'));

        $code = <<<EOT
           $("input[name=$name]").iconpicker({placement:'bottomLeft'});\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
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
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('jquery.inputmask.bundle.min.js'));

        $code = <<<EOT
           $("input[name=$name]").inputmask({
               "alias":"currency",
               "autoGroup": !0,
               "placeholder": "0",
               "prefix":"",
               "removeMaskOnSubmit":true

           });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return $this->html->tag('span', '￥', ['class' => 'input-group-addon'])
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
        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('fileinput.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('fileinput.min.js'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('canvas-to-blob.min.js'));

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
        Admin::style()->setJs(StyleTypeConst::CODE, $code);

        return self::hidden($name, $value).self::file($name, $options);
    }

    /**
     * 开关
     * @param $name
     * @param int $value
     * @return string
     */
    public function switchOff($name, $value = WhetherConst::NO)
    {
        $options['id'] = $name;
        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-switch.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-switch.min.js'));
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
            });\n
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        $checked = $value == WhetherConst::YES ? 'checked' : '';
        return self::checkbox('', '', '',  ['class' => 'switch la_checkbox', $checked]).self::hidden($name, $value);
    }

    /**
     * 迷你编辑器
     * @param $name
     * @param null $value
     * @param array $options
     * @return \Illuminate\Support\HtmlString
     */
    public function ckeditorMini($name, $value = null, $options = [])
    {
        $options['id'] = $name;
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('ckeditor.js'));
        $code = <<<EOT
           CKEDITOR.replace('$name',
            {
                toolbar : [
                    //加粗     斜体，     下划线      穿过线      下标字        上标字
                    ['Bold','Italic','Underline','Strike','Subscript','Superscript'],
                    //数字列表          实体列表            减小缩进    增大缩进
                    ['NumberedList','BulletedList','-','Outdent','Indent'],
                    //左对齐             居中对齐          右对齐          两端对齐
                    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                    //超链接 取消超链接 锚点
                    ['Link','Unlink','Anchor'],
                     //文本颜色     背景颜色
                    ['TextColor','BGColor'],
                    //全屏           显示区块
                    ['Maximize', 'ShowBlocks','-'],
                    '/',
                    //图片     表格       水平线            表情       特殊字符        分页符
                    ['Image','Html5video','Chart','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
                      //样式       格式      字体    字体大小
                    ['Styles','Format','Font','FontSize'],
                ]
            }
        );\n
EOT;

        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return self::textarea($name, $value = null, $options = []);
    }

    /**
     * 编辑器
     * @param $name
     * @param null $value
     * @param array $options
     * @return \Illuminate\Support\HtmlString
     */
    public function ckeditor($name, $value = null, $options = [])
    {
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('ckeditor.js'));
        $code = <<<EOT
           CKEDITOR.replace('$name');
EOT;

        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return self::textarea($name, $value, $options = []);
    }

    /**
     * 日期
     * @param string $name
     * @param null $value
     * @param array $options
     * @param string $format
     * @return \Illuminate\Support\HtmlString
     */
    public function datetime($name, $value = null, $options = [], $format = 'YYYY-MM-DD HH:mm:ss')
    {
        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-datetimepicker.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('moment-with-locales.min.js'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-datetimepicker.min.js'));
        $code = <<<EOT
 $('input[name={$name}]').datetimepicker({"format":"{$format}","locale":"zh-CN","allowInputToggle":true});
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return self::text($name, $value , $options);
    }

    /**
     * 日期范围
     * @param $start
     * @param $end
     * @param array $options
     * @param string $format
     * @return string
     */
    public function datetimeRange($start, $end , $options = [], $format = 'YYYY-MM-DD HH:mm:ss')
    {
        $options['style'] = 'width: 50%;';
        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-datetimepicker.min.css'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('moment-with-locales.min.js'));
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-datetimepicker.min.js'));
        $code = <<<EOT
            $('input[name={$start['name']}]').datetimepicker({"format":"{$format}","locale":"zh-CN"});
            $('input[name={$end['name']}]').datetimepicker({"format":"{$format}","locale":"zh-CN","useCurrent":false});

            $('input[name={$start['name']}]').on("dp.change", function (e) {
                $('input[name={$end['name']}]').data("DateTimePicker").minDate(e.date);
            });
            $("input[name={$end['name']}]").on("dp.change", function (e) {
                $('input[name={$start['name']}]').data("DateTimePicker").maxDate(e.date);
            });
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return self::text($start['name'], $end['value'] , $options).
        self::text($end['name'], $end['value'] , $options);
    }

    /**
     * 数字
     * @param string $name
     * @param null $value
     * @param array $options
     * @return \Illuminate\Support\HtmlString
     */
    public function number($name, $value = null, $options = [])
    {
        if(!isset($options['min'])) {
            $options['min'] = 0;
        }
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-number-input.js'));
        $code = <<<EOT
            $('input[name={$name}]')
            .addClass('initialized')
            .bootstrapNumber({
                upClass: 'success',
                downClass: 'primary',
                center: true
            });
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);
        return  self::text($name, $value , $options);
    }

    public function color($name, $value = null, $options = [])
    {
        Admin::style()->setJs(StyleTypeConst::FILE, $this->getResource('bootstrap-colorpicker.min.js'));
        Admin::style()->setCss(StyleTypeConst::FILE, $this->getResource('bootstrap-colorpicker.min.css'));
        $code = <<<EOT

            $('input[name={$name}]').parent().colorpicker({
            'format' :'hex'
            });
EOT;
        Admin::style()->setJs(StyleTypeConst::CODE, $code);


          return  '<span class="input-group-addon"><i></i></span>'.self::text($name, $value , $options);
    }
}
