<?php

$user = new Packages\AppDefault\User();
$game = new Packages\AppDefault\Game();
$API_respone = new Packages\System\SystemAPI();

//CHECK API KEY
if(isset($_POST['email']) && isset($_POST['secret_key']) )
{
    if( $user->CheckSecretKey($_POST['email'] , $_POST['secret_key']) == 1 ){
        $game_acc_info = $game->GetAccountInfo( $_POST['email'] );
        echo $API_respone->APIResponse(200, $API_respone->APIResponseBody($game_acc_info, 1));
    }  else {
        echo $API_respone->APIResponse(401, $API_respone->APIResponseBody('Unauthorized', 0));
    }
} else {
	echo $API_respone->APIResponse(401, $API_respone->APIResponseBody('Missing params', 0));
}

