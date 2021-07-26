<?php
ob_start();
session_start();
mb_internal_encoding("UTF-8");
/***** Require autoload classes of composer *****/
require_once __DIR__ .'/vendor/autoload.php';

/***** Require config file *****/
require_once __DIR__.'/config.php';

/***** Require Router *****/
if(file_exists(__DIR__ .'/router.php')){
    require_once __DIR__ .'/router.php';
} else {
    echo "Router is missing!";
}