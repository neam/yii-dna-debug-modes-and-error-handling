<?php

// Error handler

$config['import'][] = 'vendor.crisu83.yii-sentry.components.SentryErrorHandler';
$config['components']['sentry'] = array(
    'dns' => SENTRY_DSN,
    // the following two lines make sure that the sentry component is active
    'enabledEnvironments' => array('foo'),
    'environment' => 'foo',
);
$config['components']['errorHandler'] = array(
    'class' => '\YiiDnaAppErrorHandler',
    // use 'error' action to display errors, maps to the default controller, default action in ErrorModule
    'errorAction' => 'error',
);
$config['modules']['error'] = array(
    'class' => 'vendor.neam.yii-dna-debug-modes-and-error-handling.modules.error.ErrorModule',
);
if (!(in_array('YiiDnaWebApplicationTrait', class_uses(Yii::app())))) {
    throw new CException('yii-dna-debug-modes-and-error-handling is activated but the main application class does not use the required trait for the error handling to work as expected. Refer to the README for instructions.');
}
