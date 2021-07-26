<?php
$my_curl = new Packages\System\CallLibs(); 
$user = new Packages\AppDefault\User();
$game = new Packages\AppDefault\Game();
$API_respone = new Packages\System\SystemAPI();


if(isset($_SESSION['user_info']))
{
    if($_POST['playername'] != null && $_POST['password'] != null)
    {
        //check account in gnd db
        $input = array(
            'email'=>$_SESSION['user_info']['email'],
            'username'=>$_POST['playername']
        );
        $check_username = $game->GetGameInfo($input);
        if( count($check_username) == 0 )
        {
            $input = array(
                'short_name' => 'bf3',
                'playername'=> $_POST['playername'],
                'email' => $_SESSION['user_info']['email'],
                'password'=> $_POST['password']
            );

            //check ok, can connect to BF3 API
            $respone = $my_curl->PostCURL( API_BF3 . '/api/pages/update-user.php', $input );
            $data = json_decode($respone,true);
            if($data['code'] == 1)
            {
                //insert into gnd portal
                $game->CreateCharacter($_SESSION['user_info']['email'], $_SESSION['user_info']['gnd_uid'], 'bf3', $input['playername'], $data['msg']['access_key']);
                echo $API_respone->APIResponse(200, $API_respone->APIResponseBody('Connect success.', 1));
            } 
            else
            {
                echo $API_respone->APIResponse(200, $API_respone->APIResponseBody($data['msg'], 0));
            }
            //echo $API_respone->APIResponse(200, $API_respone->APIResponseBody($respone, 1));
        } 
        else //already game account
        {
            echo $API_respone->APIResponse(200, $API_respone->APIResponseBody('This account already owned this game.', 0));
        }
    } else 
    {
        echo $API_respone->APIResponse(200, $API_respone->APIResponseBody('Please fill in forms!', 0));
    }
    

} else 
{
    echo $API_respone->APIResponse(200, $API_respone->APIResponseBody('Access Denied!', 0));
}