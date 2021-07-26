<?php

$user = new Packages\AppDefault\User();
$API_respone = new Packages\System\SystemAPI();

if(isset($_POST['email']) && isset($_POST['secret_key']) )
{
    if( $user->CheckSecretKey($_POST['email'] , $_POST['secret_key']) == 1 ){
        echo $API_respone->APIResponse(200, $API_respone->APIResponseBody('helo', 1));
    } else {
        echo $API_respone->APIResponse(200, $API_respone->APIResponseBody('Unauthorized', 0));
    }
} else {
	echo $API_respone->APIResponse(200, $API_respone->APIResponseBody('Missing params', 0));
}