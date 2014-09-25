<?php

class TriggerErrorPage
{

    // include url of current page
    static $URL = 'error/default/triggerError/';

    /**
     * A friendly error page needs a link back to the web site's home page, adjust the element to match your theme
     */
    public static $backToHome = 'a.navbar-home-logo';
    //public static $backToHome = 'a.navbar-brand'; // yii-simplicity-theme

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: EditPage::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . '?' . $param;
    }

    /**
     * @var WebGuy;
     */
    protected $webGuy;

    public function __construct(WebGuy $I)
    {
        $this->webGuy = $I;
    }

    /**
     * @return SiteErrorPage
     */
    public static function of(WebGuy $I)
    {
        return new static($I);
    }

} 