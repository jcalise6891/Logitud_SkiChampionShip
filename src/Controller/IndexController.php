<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexController extends AbstractMainController
{
    private Environment $twig;
    private Session $session;
    private Request $request;

    public function __construct()
    {
        $this->twig = parent::getTwig();
        $this->session = new Session();
        $this->request = Request::createFromGlobals();
    }

    /**
     * @param $request
     * @param $attribute
     * @param $container
     */
    public function showIndex($request, $attribute, $container)
    {
        echo $container['twig']->render('index.html.twig', ['theme' => $container['theme']]);
    }
}
