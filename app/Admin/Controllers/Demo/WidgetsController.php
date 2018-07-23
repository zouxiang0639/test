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

            $item->create('display', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->display('display');
            });

            $item->create('text', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->text('text', '', $h->options);
                $h->set('text', true);
            });

            $item->create('currency', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->currency('currency', '', $h->options);
                $h->set('currency', true);
            });

            $item->create('password', function(HtmlFormTpl $h, FormBuilder $form) {
                $h->input = $form->password('password', $h->options);
                $h->set('password', true);
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
