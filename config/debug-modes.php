<?php

// DEBUG_REDIRECTS mode support

$config['components']['request'] = array(
    'class' => '\YiiDnaHttpRequest',
);

// DEBUG_LOGS mode

if (DEBUG_LOGS) {

    ini_set('xdebug.collect_params', '1');
    ini_set('xdebug.var_display_max_depth', '4');

    $_levels = array(
        'flow',
        'stat',
        YII_DEBUG ? 'trace' : null,
        'error',
        'warning',
        'profile',
        'info',
        'inspection',
        'logdump',
        'qa-state',
        //'casperjs',
    );
    $levels = implode(', ', $_levels);
    if (isset($_GET['debug_extra_log_levels']) && !empty($_GET['debug_extra_log_levels'])) {
        // relevant log levels to add on the fly: verbose_inspection
        $levels .= ', ' . $_GET['debug_extra_log_levels'];
    }

    $ajaxRequest = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

    $apiRequest = isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/api/') !== false;

    $config['components']['log']['routes']['web'] = array(
        'class' => 'CWebLogRoute',
        'levels' => $levels, //trace,
        'enabled' => !$ajaxRequest && !$apiRequest,
    );

    /* Persistent logs - inactivated but left as an example of what can be done */
    if (false) {
        $config['components']['log']['routes']['db'] = array(
            'class' => 'CDbLogRoute',
            'connectionID' => 'db',
            'logTableName' => 'yiilog_all'
        );
    }

    $config['components']['db']['enableParamLogging'] = true;
    if (!empty($_GET['db_profiling'])) {
        $config['components']['db']['enableProfiling'] = true;
    }

    $config['components']['log']['routes'][] = array(
        'class' => 'CProfileLogRoute',
        'levels' => 'trace, error, warning', //trace,
    );

    // tmp verbose output to stdout/stderr

    /*
    $config['components']['log']['routes'][] = array(
        'class' => '\neam\yii_streamlog\LogRoute', // output to stdout/err
        'levels' => 'trace',
    );
    $config['components']['log']['routes'][] = array(
        'class' => '\neam\yii_streamlog\LogRoute', // output to stdout/err
        'categories' => 'system.db.*',
        'except' => 'system.db.ar.*', // shows all db level logs but nothing in the ar category
    );
    */

}

