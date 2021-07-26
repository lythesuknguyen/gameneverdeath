<?php

namespace Packages\AppDefault;

class GameBF3 extends Game {

    use \Packages\System\Libs;

    private $game_id = 'bf3';

    function __construct(){
		$this->SelectDB(DB_BF3);
	}

    function CreateAccount($email, $game_username)
    {
    
        //Generate access key
        $this->GenerateAccessKey($email, $game_username, $this->game_id);

        $sql = "INSERT INTO `players` (`mail`, `dsnm`, `name`, `password`, `RegDate`) VALUES (:mail, :dsnm, :name, :password, :RegDate)";
        $args = array(
            'mail' => $email, 
            'dsnm' => $game_username, 
            'name' => 'player', 
            'password' => $this->access_key, 
            'RegDate' => date('Y-m-d H:i:s')
        );
        return $this->Push($sql, $args);
    }

    function ConnectToGND($email, $game_username, $gnd_uid)
    {   
        //check game account exist or not before create
        if($this->CheckAccount($game_username) === 'can create')
        {
            //step 1: create account on bf3 db
            if( $this->CreateAccount($email, $game_username) == 1 )
            {
                //step 2: get account pid
                $game_account_id = $this->GetAccount($email, $game_username)['pid'];
                //step 3: link to GND db
                if( $game_account_id != ''){
                    $this->SelectDB(DB_NAME);
                    return $this->LinkToGND($game_account_id, $this->game_id, $gnd_uid, $this->access_key);
                }
                
            } else {
                echo $this->SysMsg('error'); 
                exit();
            }
        } else if($this->CheckAccount($game_username) === 'exist') {
                echo $this->SysMsg('error'); 
                exit();
        }
        
    }

    function GetAccount($email, $game_username)
    {
        if($this->CheckAccount($game_username) === 'exist')
        {
            $sql = "SELECT * FROM `players` WHERE `dsnm` = :dsnm AND `mail` = :mail";
            $args = array(
                'dsnm'=>$game_username,
                'mail'=>$email
            );
            return $this->Fetch($sql, $args)[0];
        }
        
    }

    function CheckAccount($game_username)
    {
        $sql = "SELECT `dsnm` FROM `players` WHERE `dsnm` = :dsnm";
        $rs = $this->Fetch($sql, array('dsnm'=>$game_username) );
        if(count($rs) > 1)
        {
            echo $this->SysMsg('error'); 
            exit();
        }
        if(count($rs) == 1)
        {
            return 'exist';
        }
        if( empty($rs) )
        {
            return 'can create';
        }
        
    }

    
   
}
