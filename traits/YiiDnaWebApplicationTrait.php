<?php

/**
 * YiiDnaWebApplicationTrait class file.
 */
trait YiiDnaWebApplicationTrait
{

    /**
     * Initializes the application.
     * This method overrides the parent implementation by properly registering the errorHandler shutdown function to catch fatal errors
     */
    public function init()
    {
        parent::init();
        // Needs to be registered here to be able to catch fatal errors
        register_shutdown_function(array(Yii::app()->errorHandler, 'onShutdown'));
    }

    /**
     * Overridden so that error message is encoded prior to sending to client
     * A complete
     * @inheritdoc
     */
    public function displayError($code, $message, $file, $line)
    {
        if (YII_DEBUG) {
            parent::displayError($code, $message, $file, $line);
        } else {
            echo "<h1>PHP Error [$code]</h1>\n";
            echo "<p>" . CHtml::encode($message) . "</p>\n";
            echo '<!-- yii-dna -->';
        }
    }

    /**
     * Overridden so that exception message is encoded prior to sending to client
     * @inheritdoc
     */
    public function displayException($exception)
    {
        if (YII_DEBUG) {
            parent::displayException($exception);
        } else {
            echo '<h1>' . get_class($exception) . "</h1>\n";
            echo '<p>' . CHtml::encode($exception->getMessage()) . '</p>';
            echo '<!-- yii-dna -->';
        }
    }

}
