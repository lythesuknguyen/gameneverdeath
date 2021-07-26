<?php
if(!isset($_GET['page']) OR !isset($_GET['action'])){
    header( "HTTP/1.1 404 Not Found" );
}

$page = $_GET['page'];
$action = $_GET['action'];

$avaiable_pair = array(
    'loading'=>array('bf3','bf4','bfbc2'),
    'ads'=>array('view')
);
$module = 'landing';

if( array_key_exists($page, $avaiable_pair) == 1 && in_array($action, $avaiable_pair[$page]) == 1)
{
    

    $model = new Packages\System\CallModel();
    $view = new Packages\System\CallView(); 


    $model_params = $model->Call($module, $page, $action);
    $view->LandingView($module, $page, $action, $model_params);


} else {
    header( "HTTP/1.1 404 Not Found" );
}


