<?php

namespace App\Controller;

use App\Entity\Epreuve;
use App\Model\BDD;
use App\Model\EpreuveModel;
use App\Utility\EntityAbstract;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
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
    public function retrieveEpreuveList($request, $attributes, $container)
    {
        $connexion = new EpreuveModel($container['PDO']);
        $result = $connexion->retrieveEpreuveList();
        echo $this->twig->render(
            'epreuve/showEpreuve.html.twig',
            ['epreuveList' => $result, 'theme' => $container['theme']]
        );
    }

    public function showSingleEpreuve($request, $attributes, $container)
    {
        $result = (new EpreuveModel($container['PDO']))->retrieveSingleEpreuve($attributes['id']);
        $partList = (new BDD($container['PDO']))
            ->getListFromSpecificOption(
                'personne',
                'epreuve',
                intval($attributes['id'])
            );
        $dateTime = date_create_from_format('Y-m-d H:i:s', $result['date']);
        $stringTime = $dateTime->format('Y-m-dTH:i');
        $letterArray = array('U', 'C');
        $epreuveDate = str_replace($letterArray, '', $stringTime);
        return new Response(
            $container['twig']
                ->render(
                    'epreuve/showSingleEpreuve.html.twig',
                    [
                        'epreuve' => $result,
                        'partList' => $partList,
                        'epreuveDate' => $epreuveDate,
                        'theme' => $container['theme']
                    ]
                ), 200
        );
    }


    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function showAddEpreuve($request, $attributes, $container)
    {
        echo $this->twig->render('epreuve/addEpreuve.html.twig', ['theme' => $container['theme']]);
    }

    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @return void
     */
    public function addEpreuve($request, $attributes, $container)
    {
        try {
            if (is_string($request->get('submit'))) {
                try {
                    $newEpreuve = new Epreuve(
                        $request->get('epreuveNom'),
                        EntityAbstract::strToDateTime($request->get('epreuveDate'))
                    );
                } catch (Exception $e) {
                    echo $this->twig->render(
                        'epreuve/addEpreuve.html.twig',
                        [
                            'status' => true,
                            'errorMessage' => "L'épreuve ne peut être créer à une date antérieur à la date actuelle"
                        ]
                    );
                }
                $connexion = new BDD($container['PDO']);
                if (!$connexion->addToBDD($newEpreuve)) {
                    echo $this->twig->render(
                        'epreuve/addEpreuve.html.twig',
                        [
                            'entity' => $newEpreuve,
                            'status' => true,
                            'theme' => $container['theme'],
                            'errorMessage' => 'Il existe déjà une épreuve avec ce nom'
                        ]
                    );
                } else {
                    $response = new RedirectResponse('../../Logitud_SkiChampionShip/addEpreuve');
                    $response->send();
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
    public function deleteEpreuve($request, $attributes, $container)
    {
        $epreuveToDelete = $attributes['id'];
        $controllerArray = EntityAbstract::splitAtUpperCase($attributes['_controller']);
        $entity = strtolower(end($controllerArray));

        $connexion = new BDD($container['PDO']);
        if ($connexion->deleteFromBDD($epreuveToDelete, $entity)) {
            header('Location: ../../../../Logitud_SkiChampionShip/epreuveList');
            return true;
        } else {
            throw new Exception('Un problème est survenue pendant la suppression');
        }
    }
}
