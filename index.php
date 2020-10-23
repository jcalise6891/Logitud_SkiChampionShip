<?php

require_once(dirname(__FILE__) . "/vendor/autoload.php");


use App\Controller\ErrorController;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Pimple\Container;


$fileLocator = new FileLocator([__DIR__ . '/src/Config/']);
$loader = new YamlFileLoader($fileLocator);
$routes = $loader->load('routes.yaml');

$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$container = new Container();

try {
    $attributes = $matcher->match($request->getPathInfo());
    $object = explode('::', $attributes['_controller']);
    $class = $object[0];

    call_user_func_array([new $class(), $object[1]], [$request, $attributes,$container]);
} catch (ResourceNotFoundException $exception) {
    $response = call_user_func(new ErrorController());
    $response->send();
} catch (MethodNotAllowedException $exception) {
    echo $exception->getMessage();
}


