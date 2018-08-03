<?php

namespace App\Library\Admin\Form;

class HtmlBuilder extends \Collective\Html\HtmlBuilder
{
    /**
     * 格式化TAG标签
     * @param $tag
     * @param $class
     * @param $default
     * @return string
     */
    public function getTag($tag, $class , $default = '-')
    {
        $tagHtml = [];
        foreach($tag as $value) {

            $tagHtml[] =  $this->tag('span', e($value), ['class' => "label $class", "sta"]);

        }

        return $tagHtml ? implode('&nbsp;', $tagHtml) : $default;
    }
}