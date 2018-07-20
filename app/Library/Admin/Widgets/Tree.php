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
     * @var array
     */
    protected $items = [];

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
     * Save tree order from a input.
     *
     * @param string $serialize
     *
     * @return bool
     */
    public function saveOrder($serialize)
    {
        $tree = json_decode($serialize, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        $this->model->saveOrder($tree);

        return true;
    }

    /**
     * Build tree grid scripts.
     *
     * @return string
     */
    protected function script()
    {
        $deleteConfirm = '确认删除';
        $saveSucceeded = '保存成功';
        $refreshSucceeded = '刷新成功';
        $deleteSucceeded = '删除成功';
        $confirm = '确认';
        $cancel = '取消';

        $nestableOptions = json_encode($this->nestableOptions);

        return <<<SCRIPT

        $('#{$this->elementId}').nestable($nestableOptions);

        $('.{$this->elementId}-refresh').click(function () {
            $.pjax.reload('#pjax-container');
            toastr.success('{$refreshSucceeded}');
        });

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
     * Return all items of the tree.
     *
     * @param array $items
     */
    public function getItems()
    {
        return $this->model->withQuery($this->queryCallback)->toTree();
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
