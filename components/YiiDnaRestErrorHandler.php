<?php

/**
 * ErrorHandler trait for a REST application.
 * Overrides error and exception handling methods so that a proper REST response is always returned by the API.
 * Relies on that the WebApplication implements methods for sending the response.
 */
class YiiDnaRestErrorHandler extends YiiDnaErrorHandler
{
    /**
     * @inheritdoc
     */
    protected $required_application_trait = 'YiiDnaRestApplicationTrait';

    /**
     * @inheritdoc
     */
    protected function handleError($event)
    {
        // We need to do the sentry capturing here as the parent handler will eventually call the Yii default
        // handler, which is something we do not want to do. We want to output an appropriate REST response.
        if (error_reporting() & $event->code) {
            $this->getSentryClient()->captureException(
                $this->createErrorException($event->message, $event->code, $event->file, $event->line)
            );
        }
        Yii::app()->displayError($event->code, $event->message, $event->file, $event->line);
    }

    /**
     * @inheritdoc
     */
    protected function handleException($exception)
    {
        // We need to do the sentry capturing here as the parent handler will eventually call the Yii default
        // handler, which is something we do not want to do. We want to output an appropriate REST response.
        $this->getSentryClient()->captureException($exception);
        Yii::app()->displayException($exception);
    }
}