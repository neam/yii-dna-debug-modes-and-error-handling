<?php

class YiiDnaErrorHandler extends SentryErrorHandler
{
    /**
     * @var string the class name of the application trait the the current app must use with this error handler.
     */
    protected $required_application_trait = 'YiiDnaRestApplicationTrait';

    public function init()
    {
        parent::init();
        if (!(in_array($this->required_application_trait, class_uses(Yii::app())))) {
            throw new CException('yii-dna-debug-modes-and-error-handling is activated but the main application class does not use the required trait for the error handling to work as expected. Refer to the README for instructions.');
        }
    }

    public function onShutdown()
    {
        parent::onShutdown();

        $error = error_get_last();
        if ($error !== null) {

            // Useful for development purposes
            //var_dump($error, $this->getSentryClient()->getLoggedEventIds());

            // The information that we show to the end-user
            $publicInfo = array(
                'code' => 500,
                'loggedEventIds' => $this->getSentryClient()->getLoggedEventIds(),
            );

            // Set the error as public when in debug mode
            if (YII_DEBUG) {
                $publicInfo["error"] = $error;
            }

            // Error has already been reported by sentry - redirect to error-page instead of letting the user stare
            // at a white screen of death
            $ids = http_build_query($publicInfo);

            if (strpos(Yii::app()->request->requestUri, "site/error") === false) {
                header("Location: " . Yii::app()->request->baseUrl . "/site/error?$ids");
            } else {
                // Error when loading site/error - we can't do much but throw an exception about the error
                throw new CException("Error when loading site/error: " . print_r($error, true));
            }


        }

    }


} 