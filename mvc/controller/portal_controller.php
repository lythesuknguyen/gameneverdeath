<?php
if(isset($_GET['page']) OR isset($_GET['action'])){
    $page = $_GET['page'];
    $action = $_GET['action'];
} else {
    $page = "dashboard";
    $action = "list";
}

$avaiable_pair = array(
    'dashboard'=>array('list', 'connect-bf3'),
    'user'=>array('profile', 'profile-update', 'kyc', 'tos'),
    'game'=>array('create','play'),
    'authen'=>array('login','register','logout','recover','login_ajax')
);
$module = 'portal';

if( array_key_exists($page, $avaiable_pair) == 1 && in_array($action, $avaiable_pair[$page]) == 1)
{
    if(!isset($_SESSION['user_info']) && $page != 'authen' )
    {
        header('Location: /portal/authen/login');
    }
    if(isset($_SESSION['user_info']) && $page == 'authen' && $action == 'login')
    {
        header('Location: /portal');
    }

    $model = new Packages\System\CallModel();
    $view = new Packages\System\CallView(); 


    $model_params = $model->Call($module, $page, $action);
    $view->PortalView($module, $page, $action, $model_params);


} else {
    header( "HTTP/1.1 404 Not Found" );
}


