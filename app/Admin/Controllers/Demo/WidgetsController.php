<?php

namespace App\Admin\Controllers\Demo;

use App\Http\Controllers\Controller;
use Admin;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Response\JsonResponse;

class WidgetsController extends Controller
{
    public function form()
    {
        $form = Admin::form(function(Forms $item) {

            $item->create('number', function(HtmlFormTpl $h, FormBuilder $form) {

                $h->input = $form->number('number', 0 , $h->options);
                $h->set('number', true);
            });

            $item->create('datetimeRange', function(HtmlFormTpl $h, FormBuilder $form) {
                $start = ['name' =>'datetimeRangeStart', 'value' => ''];
                $end = ['name' =>'datetimeRangeEnd', 'value' => ''];
                $h->input = $form->datetimeRange($start, $end , $h->options, 'YYYY-MM-DD');
                $h->set('datetimeRange', true);
            });
            $item->create('datetime', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->datetime('datetime','', $h->options, 'YYYY-MM-DD');
                $h->set('datetime', true);
            });

            $item->create('switchOff', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->switchOff('switchOff','');
                $h->set('switchOff', true);
            });

            $item->create('display', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->display('display');
            });

            $item->create('icon', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->icon('icon','', $h->options);
                $h->set('icon', true);
            });

            $item->create('currency', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->currency('currency', '', $h->options);
                $h->set('currency', true);
            });

            $item->create('select2', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->select2('select2', [1,2,3,4], '', $h->options);
                $h->set('select2', true);
            });

            $item->create('multipleSelect', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->multipleSelect('multipleSelect', [1,2,3,4], '', $h->options);
                $h->set('multipleSelect', true);
            });

            $item->create('dualListBox', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->dualListBox('dualListBox', [1,2,3,4], '', $h->options);
                $h->set('dualListBox', true);
            });

            $item->create('imageOne', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->imageOne('imageOne', 'user2-160x160.jpg', $h->options);
                $h->set('imageOne', true);
            });

            $item->create('ckeditor', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->ckeditor('ckeditor', 'adsdas');
                $h->set('ckeditor', true);
            });

            $item->create('ckeditorMini', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->ckeditorMini('ckeditorMini', 'adsdas');
                $h->set('ckeditorMini', true);
            });

        })->getFormHtml();

        return view('admin::demo.widgets.form', [
            'form' => $form,
        ]);
    }

    public function formPost(\Request $request)
    {
        return (new JsonResponse())->success('http://laravel-admin.org//uploads/images/下載 (4).jpg');
    }
}
