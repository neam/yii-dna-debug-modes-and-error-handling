<?php

/**
 * Rest application response object for handling exception responses.
 */
class YiiDnaRestResponseException extends YiiDnaRestResponse
{
    /**
     * @var int the exception http status code.
     */
    public $status;

    /**
     * @var string the exception message (will include real error, file and line if YII_DEBUG is true).
     * @link http://php.net/manual/en/exception.getmessage.php
     */
    public $message;

    /**
     * @var array the exception trace stack (only when YII_DEBUG is true).
     * @link http://php.net/manual/en/exception.gettrace.php
     */
    public $trace;

    /**
     * Applies the data from the given exception instance to this response.
     * @param Exception $e the exception instance.
     */
    public function init(Exception $e)
    {
        $this->status = ($e instanceof CHttpException) ? $e->statusCode : 500;
        $this->message = self::getDefaultHttpStatusMessage($this->status);
        if (YII_DEBUG) {
            $className = get_class($e);
            $this->message =  "{$className}({$e->getCode()}): {$e->getMessage()} ({$e->getFile()}:{$e->getLine()})";
            $this->trace = $e->getTrace();
        }
    }
}