<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../framework/yiic.php';

if (strpos(gethostname(), "staging")>-1) {
    $config=dirname(__FILE__).'/config/console_staging.php';
}else if (strpos(gethostname(), "app.wearxplay.com")>-1) {
    $config=dirname(__FILE__).'/config/console_wearxplay.php';
}else if (strpos(gethostname(), "54.213.245.18")>-1) {
    $config=dirname(__FILE__).'/config/console_wearxplay.php';
} else  {
    $config=dirname(__FILE__).'/config/console.php';
}
require_once($yiic);
