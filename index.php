<?php

require_once(dirname(__FILE__) . "/vendor/autoload.php");


use App\Controller\ErrorController;
use Pimple\Container;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


$fileLocator = new FileLocator([__DIR__ . '/src/Config/']);
$loader = new YamlFileLoader($fileLocator);
$routes = $loader->load('routes.yaml');

$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);
$container = new Container();


$container['twig'] = function () {
    $templates = './src/view/';
    $loader = new FilesystemLoader($templates);
    return new Environment(
        $loader,
        ['cache' => false]
    );
};

$container['PDO'] = function () {
    $dbHost = "localhost";
    $dbPort = 3307;
    $db = "logitudski";
    return new PDO(
        'mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $db . '',
        'root',
        'root'
    );
};

$container['theme'] = $request->cookies->get('theme');

try {
    $attributes = $matcher->match($request->getPathInfo());
    $object = explode('::', $attributes['_controller']);
    $class = $object[0];

   $response = call_user_func_array([new $class(), $object[1]], [$request, $attributes, $container]);
} catch (ResourceNotFoundException $exception) {
    $response = call_user_func(new ErrorController());
} catch (MethodNotAllowedException $exception) {
    $response = new Response($exception->getMessage(), Response::HTTP_METHOD_NOT_ALLOWED);
} finally {
    $response->send();
}


