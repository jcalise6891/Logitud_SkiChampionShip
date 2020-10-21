<?php


namespace App\Controller;

use App\Utility\EntityAbstract;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Routing\Annotation\Route;

abstract class AbstractMainController extends EntityAbstract
{
    protected static $twigInstance = null;

    /**
     * @return Environment
     */
    protected static function getTwig(): Environment
    {
        if(is_null(self::$twigInstance)){
            $templates = './src/view/';
            $loader = new FilesystemLoader($templates);
            self::$twigInstance = new Environment(
                $loader,
                ['cache' => false]
            );
        }
        return self::$twigInstance;
    }

    /**
     * Rend impossible le clonage
     */
    private function __clone()
    {

    }

}