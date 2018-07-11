<?php
namespace App\Library\Response;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse as BaseJsonResponse;
use Illuminate\Support\Facades\Response as HttpResponse;

/**
 * Class JsonResponse
 * @package App\Library\Response
 */
class JsonResponse implements Contract, Jsonable
{
    /**
     * @var int
     */
    protected $code = 0;
    /**
     * @var string
     */
    protected $msg = "";
    /**
     * @var array
     */
    protected $data = [];
    /**
     * @var
     */
    protected $jsCallback;

    /**
     * @param array $withData
     * @return BaseJsonResponse
     */
    public function success($withData = [])
    {
        $this->code = 0;
        $this->msg = "success";
        $this->data = $withData;
        return $this->response();
    }

    /**
     * @param $errorCode
     * @param string $errorMessage
     * @param null $withData
     * @param boolean $isBilingual,是否显示双语,default:中文
     * @return BaseJsonResponse
     */
    public function error($errorCode, $errorMessage = '', $withData = null, $isBilingual = false)
    {
        if (empty($errorMessage)) {
            $error  = config("errno.{$errorCode}");
            if (is_array($error)) {
                if ($isBilingual) {
                    $errorMessage = implode('/', $error);//中英文案
                } else {
                    $errorMessage = $error[0];//中文
                }
            } else {
                $errorMessage = $error;
            }
        } else {
            $this->msg = $errorMessage;
        }

        $this->code = $errorCode;
        $this->msg = $errorMessage;
        $this->data = $withData;
        return $this->response();
    }

    /**
     * @return BaseJsonResponse
     */
    protected function response()
    {
        $res = array(
            "code" => $this->code,
            "msg" => $this->msg,
            "data" => $this->data,
        );

        if ($this->jsCallback) {
            return HttpResponse::jsonp($this->jsCallback, $res)->getContent();
        } else {
            return HttpResponse::json($res)->getContent();
        }
    }

    /**
     * @param $callback
     * @return $this
     */
    public function jsonp($callback)
    {
        $this->jsCallback = $callback;
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return $this->response();
    }
}