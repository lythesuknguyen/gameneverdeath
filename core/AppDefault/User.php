<?php

namespace Packages\AppDefault;

class User {

    use \Packages\System\DBConnect, \Packages\System\Libs;

    function CreateUser($email, $password)
    {
        $sql = "INSERT INTO `user` (`email`, `password`, `secret_key`, `avatar`) VALUES (:email, :password, :secret_key, :avatar)";
        $args = array(
            'email'=>$email,
            'password'=>md5($password),
            'secret_key'=>$this->GenerateSecretKey($email),
            'avatar'=>'/assets/img/user_avatars_default/default/'.rand(1,7).'.jpg',
        );
        $query = $this->Push($sql, $args);
        if( $query != 1 )
        {
            $code = '0';
            $msg = 'Failed';
        } 
        if( $query == 1)
        {
            $code = '1';
            $msg = 'Success';
        }
        // create home directory
        if (!file_exists(USER_HOME_DIR . $email)) {
            mkdir(USER_HOME_DIR . $email, 0755, true);
            mkdir(USER_HOME_DIR . $email .'/avatar', 0755, true);
            mkdir(USER_HOME_DIR . $email .'/kyc', 0755, true);
            mkdir(USER_HOME_DIR . $email .'/storage', 0755, true);
        }
        return array('code'=>$code, 'msg'=>$msg);
    }

    function GenerateSecretKey($email)
    {
        return sha1($email.uniqid());
    }

    function ValidateEmail( $email )
    {
        if( isset($email) )    //email validate
        {
            if( substr_count($email, '@' ) != 1  )
            {
                $code = '0';
                $msg = 'Wrong email format';
            }
            if( substr_count($email, '@' ) == 1 )
            {
                $sql = "SELECT * FROM `user` WHERE `email` = :email";
                $args = array('email'=>$email);
                $query = $this->RowsCount($sql, $args);
                if( $query == 0 ) 
                {
                    $code = '1';
                    $msg = 'Email can be use';
                } else if( $query != 0 ) 
                {
                    $code = '0';
                    $msg = 'Email already exist';
                }
            }
            return array('code'=>$code, 'msg'=>$msg);  
        }
    }

    function ValidatePassword( $password )
    {
        if( isset($password) )
        {
            //$number = preg_match('@[0-9]@', $password);
            //$uppercase = preg_match('@[A-Z]@', $password);
            //$lowercase = preg_match('@[a-z]@', $password);
            //$specialChars = preg_match('@[^\w]@', $password);
            
            if(strlen($password) < 6 /*|| !$number || !$uppercase || !$lowercase || !$specialChars*/) {
                $code = '0';
                //$msg = "Password must be at least 6 characters in length and must contain at least one number, one upper case letter";
                $msg = "Password must be at least 6 characters in length.";
            } else {
                $code = '1';
                $msg = "Your password is strong.";
            }
            return array('code'=>$code, 'msg'=>$msg);  
        }

    }

    function GetUserInfo( $email )
    {
       $sql = "SELECT * FROM `user` WHERE `email` = :email";
       $args = array('email'=>$email);
       return $this->Fetch($sql, $args)[0];
    }

    function CheckSecretKey($email , $secret_key)
    {
        $sql = "SELECT * FROM `user` WHERE `email` = :email AND `secret_key` = :secret_key";
        $args = array(
            'email'=>$email,
            'secret_key'=>$secret_key
        );
        return count($this->Fetch($sql, $args));
    }

    function Login($email, $password)
    {
        $sql = "SELECT * FROM `user` WHERE `email` = :email AND `password` = :password ";
        $args = array(
            'email'=>$email,
            'password'=>md5($password)
        );
        return $this->Fetch($sql, $args);
    }

    function UpdateUser( $gnd_uid, $input = array() )
    {
        $rs = array();
        //return $input;
        foreach($input as $key=>$value)
        {
            //echo $key.'->'.$value.'->';
            if($value == '')
            {
                continue;
            }
            if($value != '')
            {
                if($key == 'password')
                {                
                    $value = md5($value);             
                }
            }
            
            
            $sql = "UPDATE `user` SET `$key` = :$key WHERE `gnd_uid` = :gnd_uid ";
            $args = array(
                'gnd_uid'=>$gnd_uid,
                "$key"=>$value
            );
            $rs[$key] = $this->Push($sql, $args);           
            //echo '<br>';
        }
        return $rs;
    }


    function KYCUpload($file_upload_name)
    {
        return $this->UploadFile(KYC_UPLOAD_PATH, $file_upload_name);
    }

    function AvatarUpload($file_upload_name)
    {
        return $this->UploadFile(AVATAR_UPLOAD_PATH, $file_upload_name);
    }

}
