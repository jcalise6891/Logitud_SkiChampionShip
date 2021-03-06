<?php

namespace App\Controller;

use App\Model\BDD;
use App\Model\CategorieModel;
use App\Model\EpreuveModel;
use App\Model\PersonneModel;
use App\Model\ProfilModel;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class PersonneController
{
    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @throws Exception
     * @return Response | void
     */
    public function addPersonne($request, $attributes, $container)
    {
        try {
            $m_personne = new PersonneModel($container['PDO']);
            $m_BDD = new BDD($container['PDO']);
            $personne = $m_personne->arrayToPersonne($request->request->all());
            $m_epreuve = new EpreuveModel($container['PDO']);
            if ($m_BDD->addToBDD($personne)) {
                if ($m_epreuve->insertPersonneToEpreuveIntoBDD($attributes['id'], $personne->getID())) {
                    return new RedirectResponse(
                        '/Logitud_SkiChampionShip/' . $attributes['id'] . '/addPersonne',
                        Response::HTTP_TEMPORARY_REDIRECT
                    );
                }
            } else {
                throw new Exception('Un même participants ne peux être ajouter deux fois');
            }
        } catch (Exception $e) {
            $m_epreuve = new EpreuveModel($container['PDO']);
            $m_categorie = new CategorieModel($container['PDO']);
            $m_profil = new ProfilModel($container['PDO']);
            return new Response(
                $container['twig']->render(
                    'personne/addPersonne.html.twig',
                    [
                        'theme' => $container['theme'],
                        'epreuve' => $m_epreuve->retrieveSingleEpreuve($attributes['id']),
                        'categorieList' => $m_categorie->retrieveCategorieList(),
                        'profilList' => $m_profil->retrieveCatagorieList(),
                        'urlToRedirect' => "/Logitud_SkiChampionShip/" . $attributes['id'] . "/addPersonne",
                        'status' => true,
                        'errorMessage' => $e->getMessage(),
                    ]
                ),
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        }
    }

    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @return Response
     */
    public function showAddPersonne($request, $attributes, $container)
    {
        $m_epreuve = new EpreuveModel($container['PDO']);
        $epreuve = $m_epreuve->retrieveSingleEpreuve($attributes['id']);
        $m_categorie = new CategorieModel($container['PDO']);
        $m_profil = new ProfilModel($container['PDO']);
        return new Response(
            $container['twig']
                ->render(
                    'personne/addPersonne.html.twig',
                    [
                        'theme' => $container['theme'],
                        'epreuve' => $epreuve,
                        'categorieList' => $m_categorie->retrieveCategorieList(),
                        'profilList' => $m_profil->retrieveCatagorieList(),
                    ]
                ),
            200
        );
    }


    public function updatePersonne()
    {
    }

    public function showSinglePersonne()
    {
    }

    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @return RedirectResponse | Response
     */
    public function deletePersonne($request, $attributes, $container)
    {
        try {
            $m_personne = new PersonneModel($container['PDO']);
            $m_personne->deletePersonneFromEpreuve($attributes['idEpreuve'], $attributes['idPersonne']);
        }catch (Exception $e){
            return new Response(
                $container['twig']
                    ->render(
                       'epreuve/showSingleEpreuve.html.twig',
                        [
                            'theme' => $container['theme'],
                            'status' => true,
                            'urlToRedirect' => '/Logitud_SkiChampionShip/showEpreuve/'.$attributes['idEpreuve'],
                            'errorMessage' => $e->getMessage(),
                            'currentEpreuve' => $attributes['id']
                        ]
                    ), Response::HTTP_BAD_REQUEST
            );
        }
        return new RedirectResponse(
            '/Logitud_SkiChampionShip/showEpreuve/'.$attributes['idEpreuve'],
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }
}
