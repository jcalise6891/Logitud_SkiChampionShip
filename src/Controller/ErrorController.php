<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ErrorController extends AbstractMainController
{
    private Environment $twig;

    /**
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke()
    {
        $this->twig = parent::getTwig();
        return new Response($this->twig->render('exception/error404.html.twig'),404);
    }

}