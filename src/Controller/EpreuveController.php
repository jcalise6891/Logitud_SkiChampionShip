<?php

namespace App\Controller;

use App\Entity\Epreuve;
use App\Model\BDD;
use App\Utility\EntityAbstract;
use Exception;
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

    public function showAddEpreuve()
    {
        echo $this->twig->render('epreuve/addEpreuve.html.twig');
    }

    /**
     * @param $request
     * @return void
     */
    public function addEpreuve($request)
    {
        try {
            if (is_string($request->get('submit'))) {
                $newEpreuve = new Epreuve(
                    $request->get('epreuveNom'),
                    EntityAbstract::strToDateTime($request->get('epreuveDate'))
                );
                $connexion = new BDD('logitudski', 'localhost', '3307', 'root', 'root');
                $db = $connexion->connectToBDD();
                if (!$connexion->addToBDD($db, $newEpreuve)) {
                    echo $this->twig->render(
                        'epreuve/addEpreuve.html.twig',
                        [
                            'entity' => $newEpreuve,
                            'status' => true,
                            'errorMessage' => 'Il existe déjà une épreuve avec ce nom'
                        ]
                    );
                }
            } else {
                throw new Exception("Erreur: Ne peux pas créer l'épreuve");
            }
        } catch (Exception $e) {
            echo 'Exception : ', $e->getMessage(), "<br>";
        }
    }

    /**
     * @param $request
     * @param $attributes
     * @return bool
     * @throws Exception
     */
    public function deleteEpreuve($request, $attributes)
    {
        $epreuveToDelete = $attributes['id'];
        $controllerArray = EntityAbstract::splitAtUpperCase($attributes['_controller']);
        $entity = strtolower(end($controllerArray));

        $connexion = new BDD('logitudski', 'localhost', '3307', 'root', 'root');
        $pdo = $connexion->connectToBDD();
        if ($connexion->deleteFromBDD($pdo, $epreuveToDelete, $entity)) {
            header('Location: ../../../../Logitud_SkiChampionShip/epreuveList');
            return true;
        } else {
            throw new Exception('Un problème est survenue pendant la suppression');
        }
    }
}
