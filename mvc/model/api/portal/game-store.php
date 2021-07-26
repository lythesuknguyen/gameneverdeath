<?php
$game = new \Packages\AppDefault\Game(); 
$game_list = $game->GetListGame();
$API_respone = new Packages\System\SystemAPI();

//print_r($game_list);

echo $API_respone->APIResponse(200, $API_respone->APIResponseBody($game_list, 1));