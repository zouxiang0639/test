<?php

namespace App\Library\Admin\Widgets;

use App\Library\Admin\Consts\StyleTypeConst;
use Closure;
use App\Library\Admin\Tree\Tools;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Admin;

class Tree implements Renderable
{

    /**
     * 生成树
     */
    const BUILD_TREE = 1;
    /**
     * 生成select树选项
     */

    const BUILD_SELECT_OPTIONS = 2;
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $data = [];
    /**
     * @var string
     */
    protected $elementId = 'tree-';

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var \Closure
     */
    protected $queryCallback;

    /**
     * View of tree to render.
     *
     * @var string
     */
    protected $view = [
        'tree'   => 'admin::tree',
        'branch' => 'admin::tree.branch',
    ];

    /**
     * @var \Closure
     */
    protected $callback;

    /**
     * @var null
     */
    protected $branchCallback = null;

    /**
     * @var bool
     */
    public $useCreate = true;

    /**
     * @var bool
     */
    public $useSave = true;

    /**
     * @var bool
     */
    public $useRefresh = true;

    /**
     * @var array
     */
    protected $nestableOptions = [];

    /**
     * Header tools.
     *
     * @var Tools
     */
    public $tools;

    /**
     * Menu constructor.
     *
     * @param Model|null $model
     */
    public function __construct($model = null, \Closure $callback = null)
    {
        $this->model = $model;

        $this->path = app('request')->getPathInfo();

        $this->elementId .= uniqid();

        $this->setupTools();

        if ($callback instanceof \Closure) {
            call_user_func($callback, $this);
        }

        $this->initBranchCallback();
    }

    /**
     * Setup tree tools.
     */
    public function setupTools()
    {
        $this->tools = new Tools($this);
    }

    /**
     * Initialize branch callback.
     *
     * @return void
     */
    protected function initBranchCallback()
    {
        if (is_null($this->branchCallback)) {
            $this->branchCallback = function ($branch) {
                $key = $branch[$this->model->getKeyName()];
                $title = $branch[$this->model->getTitleColumn()];

                return "$key - $title";
            };
        }
    }

    /**
     * Set branch callback.
     *
     * @param \Closure $branchCallback
     *
     * @return $this
     */
    public function branch(\Closure $branchCallback)
    {
        $this->branchCallback = $branchCallback;

        return $this;
    }

    /**
     * Set query callback this tree.
     *
     * @return Model
     */
    public function query(\Closure $callback)
    {
        $this->queryCallback = $callback;

        return $this;
    }

    /**
     * Set nestable options.
     *
     * @param array $options
     *
     * @return $this
     */
    public function nestable($options = [])
    {
        $this->nestableOptions = array_merge($this->nestableOptions, $options);

        return $this;
    }

    /**
     * Disable create.
     *
     * @return void
     */
    public function disableCreate()
    {
        $this->useCreate = false;
    }

    /**
     * Disable save.
     *
     * @return void
     */
    public function disableSave()
    {
        $this->useSave = false;
    }

    /**
     * Disable refresh.
     *
     * @return void
     */
    public function disableRefresh()
    {
        $this->useRefresh = false;
    }



    /**
     * Build tree grid scripts.
     *
     * @return string
     */
    protected function script()
    {

        $nestableOptions = json_encode($this->nestableOptions);

        return <<<SCRIPT
        $('.{$this->elementId}-save').click(function () {
            var serialize = $('#{$this->elementId}').nestable('serialize');
            $.post('{$this->path}', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _order: JSON.stringify(serialize)
            },
            function(res){
                res = JSON.parse(res);
                swal(res.data, '', 'success');
                //window.location.href = document.location;
            });
        });
        $('#{$this->elementId}').nestable($nestableOptions);

        $('.{$this->elementId}-tree-tools').on('click', function(e){
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse') {
                $('.dd').nestable('collapseAll');
            }
        });


SCRIPT;
    }

    /**
     * Set view of tree.
     *
     * @param string $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }


    /**
     * 设置数据树
     * @param int $type
     */
    public function setItems($type = Tree::BUILD_TREE)
    {
        switch($type) {
            case self::BUILD_TREE :
                $this->items = $this->buildTree();
                break;
            case self::BUILD_SELECT_OPTIONS :
                $this->items = $this->buildSelectOptions();
                break;
            default:
                break;
        }

    }

    /**
     * @param Closure $model
     * @return $this
     */
    public function setDate(\Closure $model)
    {
        $this->data = $model($this->model)->get();
        return $this;
    }

    public function toArray()
    {
        $this->data = $this->data->toArray();
        return $this;
    }

    /**
     * 生成成数据树
     * @param int $parentId
     * @return array
     */
    public function buildTree($parentId = 0)
    {
        $branch = [];
        foreach ($this->data as $node) {

            if ($node['parent_id'] == $parentId) {

                $children = $this->buildTree($node[$this->model->getKeyName()]);

                if ($children) {
                    $node['children'] = $children;

                }
                $branch[] = $node;

            }
        }

        return $branch;
    }
    /**
     * Build options of select field in form.
     *
     * @param int    $parentId
     * @param string $prefix
     *
     * @return array
     */
    protected function buildSelectOptions($parentId = 0, $prefix = '')
    {
        $prefix = $prefix ?: str_repeat('&nbsp;', 6);

        $options = [];

        foreach ($this->data as $node) {
            $node['title'] = $prefix.'&nbsp;'.$node['title'];
            if ($node['parent_id'] == $parentId) {
                $children = $this->buildSelectOptions($node[$this->model->getKeyName()], $prefix.$prefix);

                $options[$node[$this->model->getKeyName()]] = $node['title'];

                if ($children) {
                    $options += $children;
                }
            }
        }

        return $options;
    }


    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Variables in tree template.
     *
     * @return array
     */
    public function variables()
    {
        return [
            'id'         => $this->elementId,
            'tools'      => $this->tools->render(),
            'items'      => $this->getItems(),
            'useCreate'  => $this->useCreate,
            'useSave'    => $this->useSave,
            'useRefresh' => $this->useRefresh,
        ];
    }

    /**
     * Setup grid tools.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function tools(Closure $callback)
    {
        call_user_func($callback, $this->tools);
    }

    /**
     * Render a tree.
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function render()
    {
        Admin::setJs(StyleTypeConst::CODE, $this->script());

        view()->share([
            'path'           => $this->path,
            'keyName'        => $this->model->getKeyName(),
            'branchView'     => $this->view['branch'],
            'branchCallback' => $this->branchCallback,
        ]);

        return view($this->view['tree'], $this->variables())->render();
    }


    /**
     * Get the string contents of the grid view.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
