<?php

namespace Packages\AppDefault;

class Game extends User {

    use \Packages\System\Libs;

    protected $access_key;


    function GetAccountInfo($email)
    {
        $sql = "SELECT `username`, `game_name`,`access_key` FROM `ingame_name` WHERE `email` = :email";
        $args = array('email'=>$email);
        return $this->Fetch($sql, $args);
    }

    function GetListGame()
    {
        $sql = "SELECT * FROM `gnd_game_list` ORDER BY `position` ASC";
        return $this->Fetch($sql, null);
    }

    function GetGameInfoByEmailAndShortName($email, $short_name)
    {
        $sql = "SELECT * FROM `ingame_name` WHERE `email` = :email AND `game_name` = :game_name";
        $args = array(
            'email'=>$email,
            'game_name'=>$short_name
        );
        return $this->Fetch($sql, $args);
    }

    function GetGameInfo($condition = array())
    { 
        $lastElement = end($condition);
        $args = array();
        $sql = "SELECT `username`, `game_name`,`access_key` FROM `ingame_name` WHERE ";
        foreach($condition as $key=>$value)
        {
            $sql .= "`$key` = :$key";
            if($value != $lastElement) 
            {
                $sql .= " AND ";
            }
            
            $args[$key] = $value;
        }
        //echo $sql;
        return $this->Fetch($sql, $args);
    }

    protected function GenerateAccessKey($email, $game_username, $game_id)
    {
        $this->access_key = md5($email.strtotime("now").$game_username.$game_id);

    }

    function CreateCharacter($email, $gnd_uid, $game_name, $username, $access_key)
    {
        $sql = "INSERT INTO `ingame_name` (`username`, `email`, `gnd_uid`, `game_name`, `access_key`) VALUES (:username, :email, :gnd_uid, :game_name, :access_key)";
        $args = array(
            'username'=>$username, 
            'email'=>$email, 
            'gnd_uid'=>$gnd_uid, 
            'game_name'=>$game_name,
            'access_key'=>$access_key
        );
        return $this->Push($sql, $args);
    }

}
