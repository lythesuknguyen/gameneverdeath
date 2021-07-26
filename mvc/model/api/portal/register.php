<?php

if(isset($_POST))
{
    //print_r($_POST);
    $user = new \Packages\AppDefault\User();
    if($_POST['query'] == 'email')
    {
        $rs_email = $user->ValidateEmail( $_POST['email']);
        print_r( json_encode($rs_email) );
    }

    if($_POST['query'] == 'password')
    {
        $rs_password = $user->ValidatePassword( $_POST['password']);
        print_r( json_encode($rs_password) );
    }

    if($_POST['query'] == 'reg')
    {
        if( $user->ValidateEmail( $_POST['email'])['code']==1 AND  $user->ValidatePassword( $_POST['password'])['code']==1 )
        {
            print_r(json_encode($user->CreateUser($_POST['email'], $_POST['password'])));
        }
        
    }
}