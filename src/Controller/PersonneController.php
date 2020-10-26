<?php

namespace App\Controller;

use App\Model\BDD;
use App\Model\EpreuveModel;

class PersonneController
{
    public function addPersonne($request, $attributes, $container){

    }

    public function deletePersonne(){

    }

    public function updatePersonne(){

    }

    public function showPersonneList($request, $attributes, $container){
        $pdo = $container['PDO'];
        dump($personneList);

    }

    public function showSinglePersonne(){

    }
}
