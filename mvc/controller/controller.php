<?php




if($_GET['module'] === 'portal' OR $_GET['module'] === 'portal/')
{
    require_once ROOTPATH . '/mvc/controller/portal_controller.php';
}

if($_GET['module'] === 'logout' OR $_GET['module'] === 'logout/')
{
    if( !$_SESSION['user_info']['role'] == 'user' )
    {
        header('Location: /portal');
    }

    if( $_SESSION['user_info']['role'] == 'user' )
    {
        session_destroy();
        header('Location: /portal');
    }
    if( $_SESSION['user_info']['role'] == 'admin' )
    {
        session_destroy();
        header('Location: /admin');
    }
    
}

if($_GET['module'] === 'api' OR $_GET['module'] === 'api/')
{
    require_once ROOTPATH . '/mvc/controller/api_controller.php';
}

if($_GET['module'] === 'landing' OR $_GET['module'] === 'landing/')
{
    require_once ROOTPATH . '/mvc/controller/landing_controller.php';
}