<?php

trait YiiDnaHttpRequestTrait
{

    public function redirect($url, $terminate = true, $statusCode = 302)
    {

        if (defined("DEBUG_REDIRECTS") && DEBUG_REDIRECTS) {
            Yii::log("Development mode redirect", "flow", __METHOD__);
            echo CHtml::link("Development mode - Click to continue to automatic redirect: $url (Terminate: $terminate Status-code: $statusCode)", $url);
            Yii::app()->end($status = 0, $terminate);
        } else {
            parent::redirect($url, $terminate, $statusCode);
        }

    }
}