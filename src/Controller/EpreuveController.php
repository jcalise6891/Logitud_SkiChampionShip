<?php


namespace App\Controller;

use App\Entity\Epreuve;
use App\Model\BDD;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EpreuveController extends AbstractMainController
{
    private Environment $twig;

    /**
     * EpreuveController constructor.
     */
    public function __construct()
    {
        $this->twig = parent::getTwig();
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function retrieveEpreuveList()
    {
        $connexion = new BDD(
            'logitudski',
            'localhost',
            '3307',
            'root',
            'root'
        );
        $db = $connexion->connectToBDD();
        $result = $connexion->getEntityListFromBDD($db, 'epreuve');


        echo $this->twig->render('epreuve/showEpreuve.html.twig', ['epreuveList' => $result]);
    }

    /**
     * @param $request
     * @return bool
     */
    public function addEpreuve($request)
    {
        try {
            if (is_string($request->get('submit'))) {
                $newEpreuve = new Epreuve(
                    $request->get('epreuveNom'),
                    $request->get('epreuveDate')
                );
                $connexion = new BDD('logitudski', 'localhost', '3307', 'root', 'root');
                $db = $connexion->connectToBDD();
                return $connexion->addToBDD($db, $newEpreuve);
            } else {
                throw new Exception("Erreur: Ne peux pas créer l'épreuve");
            }
        } catch (Exception $e) {
            echo 'Exception : ', $e->getMessage(), "<br>";
        }
    }

    /**
     * @param $request
     */
    public function deleteEpreuve($request)
    {
        try {
            if (is_string($request->get('oui'))) {
                echo 'hello';
            }
        } catch (Exception $e) {
            echo 'Exception : ', $e->getMessage(), "<br>";
        }
    }
}
