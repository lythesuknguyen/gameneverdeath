<?php
$my_curl = new Packages\System\CallLibs(); 
$user = new Packages\AppDefault\User();
$game = new Packages\AppDefault\Game();
$API_respone = new Packages\System\SystemAPI();

//CHECK API KEY
if(isset($_POST['email']) && isset($_POST['secret_key']) && isset($_POST['short_name']) )
{
    if( $user->CheckSecretKey($_POST['email'] , $_POST['secret_key']) == 1 ){
        if($_POST['short_name'] == 'bf3')
        {
            $respone = $my_curl->PostCURL( API_BF3 . '/api/pages/create-user.php', $_POST );
            $data = json_decode($respone,true);
            if($data['code'] == 1)   // insert playername to to portal db
            {
                $gnd_uid = $user->GetUserInfo($_POST['email'])['gnd_uid'] ;  // get gnd_uid

                $access_key = $data['msg']['password'];
                $email = $data['msg']['mail'];
                $username = $data['msg']['dsnm'];

                $game->CreateCharacter($email, $gnd_uid, 'bf3', $username, $access_key);
                echo $API_respone->APIResponse(200, $API_respone->APIResponseBody($data['msg'], 1));
                
            } else {
                echo $API_respone->APIResponse(200, $API_respone->APIResponseBody($data['msg'], 0));
            }
            
    
        }
    }  else {
        echo $API_respone->APIResponse(401, $API_respone->APIResponseBody('Unauthorized', 0));
    }
} else {
	echo $API_respone->APIResponse(401, $API_respone->APIResponseBody('Missing params', 0));
}

