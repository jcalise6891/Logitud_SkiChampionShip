<?php

namespace App\Controller;

use App\Model\EpreuveModel;
use Symfony\Component\HttpFoundation\Response;

class PersonneController
{
    public function addPersonne($request, $attributes, $container)
    {
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
        return new Response(
            $container['twig']
                ->render(
                    'personne/addPersonne.html.twig',
                    [
                        'theme' => $container['theme'],
                        'epreuve' => $epreuve
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
