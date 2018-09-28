<?php

namespace App\Admin\Controllers\Contents;

use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use App\Http\Controllers\Controller;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Forum\Widgets\Tags;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Admin;
use View;
use Forum;
use Auth;

class ArticleController  extends Controller
{

    public function index(Request $request)
    {
        $userTags = Auth::guard('admin')->user()->tags;
        if(!empty($userTags) && !empty($request->tag) && !in_array($request->tag, $userTags)) {
            throw new LogicException(1010005, '你没有权限');
        }

        if(empty($request->tag)) {
            $request->tag = $userTags;
        }

        $list = ArticleBls::getArticleLise($request);
        $tags = (new Tags(TagsTypeConst::TAG))->getTagsOption();


        $list->getCollection()->each(function($item) use ($tags) {
            $item->tagsName = array_get($tags, $item->tags);
            $item->issuerName = '-';

            if($issuer = $item->issuers) {
                $item->issuerName = $issuer->name;
            }
        });

        return View::make('admin::contents.article.index', [
            'list' => $list,
            'tags' => $userTags ? (new Tags(TagsTypeConst::TAG))->getSpecifyTags($userTags) : $tags
        ]);
    }

    public function edit($id)
    {
        $model = ArticleBls::findByWithTrashed($id);

        $userTags = Auth::guard('admin')->user()->tags;
        if(!empty($userTags) && !in_array($model->tags, $userTags)) {
            throw new LogicException(1010005, '你没有权限');
        }

        return View::make('admin::contents.article.edit', [
            'form' => $this->form($model),
            'info' => $model,
        ]);
    }

    public function update(ArticleCreateRequest $request, $id)
    {
        // 敏感词替换为***为例
        $request->contents = Forum::sensitive($request->contents);
        $request->title = Forum::sensitive($request->title);

        $model = ArticleBls::findByWithTrashed($id);

        if (ArticleBls::updateArticle($request, $model)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function destroy($id)
    {
        $model = ArticleBls::find($id);
        $this->isEmpty($model);

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    public function reduction($id)
    {
        $model = ArticleBls::findByWithTrashed($id);
        $this->isEmpty($model);

        if($model->restore()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    public function hotSearch($id)
    {
        $model = ArticleBls::find($id);
        $this->isEmpty($model);
        $model->is_hot = WhetherConst::YES;
        $model->hot_search_time = date('Y-m-d H:i:s');

        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    /**
     * 表单
     *
     * Make a form builder.
     * @param $info
     * @return mixed
     */
    protected function form($info)
    {
        return Admin::form(function(Forms $item) use ($info)  {

            $item->create('编号', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'id'));
            });

            if($info->deleted_at) {
                $item->create('文章状态', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                    $h->input = $form->display('文章被删除');
                });
            }

            $item->create('标题', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('title', array_get($info, 'title'), $h->options);
                $h->set('title', true);
            });

            $item->create('来源', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('source', array_get($info, 'source'), $h->options);
                $h->set('source', true);
            });

            $item->create('浏览量', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->number('browse', array_get($info, 'browse'), $h->options);
                $h->set('browse', true);
            });

            $item->create('推荐量', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->number('recommend_count', array_get($info, 'recommend_count'), $h->options);
                $h->set('recommend_count', true);
            });

            $item->create('ip', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'ip'));
            });

            $item->create('标签', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $tags = ( new Tags(TagsTypeConst::TAG))->getTagsOption();
                $h->input = $form->select('tags',$tags, array_get($info, 'tags'), $h->options);
                $h->set('tags', true);
            });



            $item->create('内容', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->ckeditor('contents', array_get($info, 'contents'), $h->options);
                $h->set('contents', true);
            });

            $item->create('创建时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'created_at'));
            });

            $item->create('更新时间', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->display(array_get($info, 'updated_at'));
            });
        })->getFormHtml();
    }

}
