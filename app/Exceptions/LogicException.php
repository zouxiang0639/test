<?php
namespace App\Exceptions;

use InvalidArgumentException;
use Exception;

/**
 * Class LogicException
 * @package App\Exceptions
 */
class LogicException extends Exception
{
    /** @var array */
    protected $data;

    /**
     * @param int $code
     * @param array $data
     * @param string $message
     */
    public function __construct($code = 0, $data = array(), $message = "")
    {
        $this->data = $data;
        $message = $this->buildMessage($code, $message);

        parent::__construct($message, $code);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $code
     * @param $message
     * @return mixed
     */
    private function buildMessage($code, $message)
    {
        if (!empty($message)) {
            return $message;
        }

        $message = config("errno.{$code}");
        if (empty($message)) {
            throw new InvalidArgumentException("Illegal error code: {$code}.");
        }
        return $message;
    }
}