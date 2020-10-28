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
     */
    public function addPersonne($request, $attributes, $container)
    {
        try{
            $m_personne = new PersonneModel($container['PDO']);
            $m_BDD = new BDD($container['PDO']);
            $m_epreuve = new EpreuveModel($container['PDO']);
            $m_categorie = new CategorieModel($container['PDO']);
            $m_profil = new ProfilModel($container['PDO']);
            $personne = $m_personne->arrayToPersonne($request->request->all());
            dump($request->request->all());
            dump($personne);
            dump($personne->getDateDeNaissance()->format('Y-m-d'));
            if($m_BDD->addToBDD($personne))
            {
                if($m_epreuve->insertPersonneToEpreuveIntoBDD($attributes['id'],$personne->getID())) {
                    return new RedirectResponse(
                        '/Logitud_SkiChampionShip/' . $attributes['id'] . '/addPersonne',
                        Response::HTTP_TEMPORARY_REDIRECT
                    );
                }
            }
        }catch (Exception $e){
            return new Response(
                $container['twog']
                    ->render(
                        'personne/addPersonne.html.twig',
                        [
                            'theme' => $container['theme'],
                            'epreuve' => $m_epreuve->retrieveSingleEpreuve($attributes['id']),
                            'categorieList' => $m_categorie->retrieveCategorieList(),
                            'profilList' => $m_profil->retrieveCatagorieList(),
                            'errorMessage' => "Il y à eu un problème lors de l'ajout du participant",
                            'status' => true
                        ]
                    ), Response::HTTP_METHOD_NOT_ALLOWED
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
                ), 200
        );
    }


    public function updatePersonne()
    {
    }

    public function showSinglePersonne()
    {
    }
}
