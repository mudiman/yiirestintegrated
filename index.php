<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

if (strpos($_SERVER['SERVER_NAME'], "staging")>-1) {
    $config=dirname(__FILE__).'/protected/config/staging.php';
} else if (strpos($_SERVER['SERVER_NAME'], "beta")>-1) {
    $config=dirname(__FILE__).'/protected/config/beta.php';
}else{
    $config=dirname(__FILE__).'/protected/config/main.php';
}

require_once($yii);
Yii::createWebApplication($config)->run();
