<?php

// Error handler

$config['import'][] = 'vendor.neam.yii-dna-debug-modes-and-error-handling.components.*';
$config['import'][] = 'vendor.neam.yii-dna-debug-modes-and-error-handling.exceptions.*';
$config['import'][] = 'vendor.neam.yii-dna-debug-modes-and-error-handling.traits.YiiDnaWebApplicationTrait';
$config['import'][] = 'vendor.crisu83.yii-sentry.components.SentryErrorHandler';
$config['import'][] = 'vendor.crisu83.yii-sentry.components.SentryClient';
$config['components']['sentry'] = array(
    'class' => '\SentryClient',
    'dns' => SENTRY_DSN,
    'enabledEnvironments' => array(),
    'environment' => 'foo',
);
if (defined('SENTRY_DSN') && !is_null(SENTRY_DSN)) {
    $config['components']['sentry']['enabledEnvironments'][] = 'foo';
}
$config['components']['errorHandler'] = array(
    'class' => '\YiiDnaErrorHandler',
    // use 'error' action to display errors, maps to the default controller, default action in ErrorModule
    'errorAction' => 'error',
);
$config['modules']['error'] = array(
    'class' => 'vendor.neam.yii-dna-debug-modes-and-error-handling.modules.error.ErrorModule',
);
