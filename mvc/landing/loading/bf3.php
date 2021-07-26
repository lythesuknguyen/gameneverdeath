<?php


if( isset($_SESSION['user_info']) && $_GET['action']=='bf3' )
{
    $game = new Packages\AppDefault\Game();
    $a = $game->GetGameInfoByEmailAndShortName($_SESSION['user_info']['email'], $_GET['action'])[0];
    $login_info = array(
        'act'=>'login',
        'username'=>$a['username'],
        'password'=>$a['access_key']
    );
}