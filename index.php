<?php

require_once(dirname(__FILE__)."/vendor/autoload.php");

use App\Routing\Router;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$url = $request->get("url");
$router = new Router($url);

try{
    $router->get('/','Hello');
}catch (Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

require(dirname(__FILE__)."/tests/result/resultat.html");