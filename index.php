<?php

require_once(dirname(__FILE__)."/vendor/autoload.php");

use App\Routing\Router;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$url = $request->get("url");
$router = new Router($url);

$router->get('/', "Index#showIndex");

try {
    $router->run();
} catch (\Exception $e) {
    echo 'Exception error : '.$e->getMessage();
}
