<?php
namespace App\Library\Response;

/**
 * Interface Contract
 * @package Dffl\Service\Library\Response
 */
interface Contract
{
    /**
     * @param array $data
     * @return mixed
     */
    public function success($data = []);

    /**
     * @param $code
     * @param string $msg
     * @return mixed
     */
    public function error($code, $msg = '');

    /**
     * @param $callback
     * @return mixed
     */
    public function jsonp($callback);
}