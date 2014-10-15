<?php

class YiiDnaErrorHandler extends SentryErrorHandler
{
    /**
     * @var string the class name of the application trait the the current app must use with this error handler.
     */
    protected $required_application_trait = 'YiiDnaWebApplicationTrait';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!(in_array($this->required_application_trait, class_uses(Yii::app())))) {
            throw new CException('yii-dna-debug-modes-and-error-handling is activated but the main application class does not use the required trait for the error handling to work as expected. Refer to the README for instructions.');
        }
    }

    /**
     * @inheritdoc
     */
    public function onShutdown()
    {
        parent::onShutdown();
        $this->handleShutdown();
    }

    /**
     * Handler for the shutdown event.
     * This is a separate function to make it possible to extend the functionality but keep calling
     * SentryErrorHandler::onShutdown().
     *
     * @throws CException if the redirect to the friendly error page can't be realized.
     */
    protected function handleShutdown()
    {
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

            $isFatal = ($error["type"] == E_ERROR);

            // todo: fix hard-coded path
            if (strpos(Yii::app()->request->requestUri, "site/error") === false) {

                $url = Yii::app()->request->baseUrl . "/site/error?$ids";
                if (!headers_sent($filename, $linenum)) {
                    header("Location: $url");
                    exit;
                } else {
                    throw new CException("Shutdown handler error redirect to $url failed since headers were sent in $filename on line $linenum. Error: " . print_r($error, true));
                    exit;
                }

            } else {
                // Error when loading site/error - we can't do much but throw an exception about the error
                throw new CException("Error when loading site/error: " . print_r($error, true));
            }
        }
    }
} 