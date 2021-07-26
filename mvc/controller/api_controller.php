<?php
if(!isset($_GET['page']) OR !isset($_GET['action'])){
    header( "HTTP/1.1 404 Not Found" );
}


$module = 'api';
$model = new Packages\System\CallModel();
require $model->Call($module, $_GET['page'], $_GET['action']);


