<?php

namespace App\Library\Forum\Widgets;


use App\Admin\Bls\Other\FragmentBls;

class Fragment
{
    private $item = [];

    public function get($id, $name)
    {

        if(isset($this->item[$id])) {
            return $this->item[$id][$name];
        }

        $model = FragmentBls::find($id);
        $this->item[$id] = $model;

        return $model[$name];
    }
}