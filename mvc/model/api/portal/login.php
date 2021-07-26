<?php 

$user = new \Packages\AppDefault\User();
$API_respone = new Packages\System\SystemAPI();

if( isset($_POST['email']) && isset($_POST['password']))
{
    if( count($user->Login($_POST['email'], $_POST['password'])) == 1 )
    {
        $user_info = $user->GetUserInfo( $_POST['email'] );
        //update secret key
        unset($user_info['password']);
        unset($user_info['id_row']);
        $_SESSION['user_info'] = $user_info;
		//$sec_key = $user_info['secret_key'];
        echo $API_respone->APIResponse(200, $API_respone->APIResponseBody($_SESSION['user_info'], 1));
    } else {
        echo $API_respone->APIResponse(200, $API_respone->APIResponseBody('unauthorized', 0));
    }
} else {
    echo $API_respone->APIResponse(200, $API_respone->APIResponseBody('Missing params', 0));
}