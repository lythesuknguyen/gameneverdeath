<?php

$router = new \Packages\System\AltoRouter();


//****  ROUTES DEFINE  ****//

$router->map('GET|POST','/test', ROOTPATH . '/test.php');

$router->map('GET|POST','/[*:module]?/[*:page]?/[*:action]?/[*:params]?', ROOTPATH . '/mvc/controller/controller.php');


//**** MATCH ROUTES TO FILES ****//
$match = $router->match();

if($match) {
	$_GET = $match['params']; 
	require $match['target'];
}
else {
	//header( "HTTP/1.1 404 Not Found" );
	if(!isset($match['params']))
	{
		header('Location: portal/');
	}
}
