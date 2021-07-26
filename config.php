<?php

//**** SET DEBUG MODE ****//
// 1 - enabled | 0 - disabled
DebugMode(0);


//**** CHANGE YOUR DATABASE INFO ****//
define('DB_TYPE','mysql');
@define('DB_HOST','localhost');
@define('DB_NAME','');
define('DB_CHARSET','utf8');
@define('DB_USER','');
@define('DB_PASSWORD','');


//**** API URLs****//
@define('API_BF3', 'https://bf3.gameneverdeath.com');

// CONFIG YOUR TIMEZONE. IF YOU NOT SURE, PLEASE VISIT LINK BELOW TO GET LIST OF TIMEZONE 
/* http://php.net/manual/en/timezones.php */
@define('SERVER_TIME_ZONE','Asia/Ho_Chi_Minh');
date_default_timezone_set(SERVER_TIME_ZONE);


//**** DEFINE ROOT PATH ****//
@DEFINE('ROOTPATH', __DIR__);

//**** USER HOME DIR****//
@define('USER_HOME_DIR', ROOTPATH .'/assets/users/');

//**** AVATAR PATH****//
@define('AVATAR_UPLOAD_PATH', ROOTPATH .'/assets/users/'.$_SESSION['user_info']['email'].'/avatar/');
@define('AVATAR_URL_PATH', '/assets/users/'.$_SESSION['user_info']['email'].'/avatar/');
//**** KYC PATH****//
@define('KYC_UPLOAD_PATH', ROOTPATH .'/assets/users/'.$_SESSION['user_info']['email'].'/kyc/');
@define('KYC_URL_PATH', '/assets/users/'.$_SESSION['user_info']['email'].'/kyc/');
//**** STORAGE PATH****//
@define('STORAGE_UPLOAD_PATH', ROOTPATH .'/assets/users/'.$_SESSION['user_info']['email'].'/storage/');
@define('STORAGE_URL_PATH', '/assets/users/'.$_SESSION['user_info']['email'].'/storage/');

//**** DEBUG MODE PROCESS ****//
function DebugMode($debug_mode){
    if($debug_mode == 1){
        error_reporting(E_ALL);
        ini_set('display_errors',TRUE);
        @define('DEBUG_MODE', 1);
    } else if($debug_mode == 0){
        error_reporting(0);
        ini_set('display_errors',FALSE);
        @define('DEBUG_MODE', 0);
    }
}
