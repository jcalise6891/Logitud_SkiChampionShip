<?php


namespace App\Entity;


use App\Utility\EntityAbstract;
use Exception;

class Categorie extends EntityAbstract
{
    private String $nom;

    /**
     * Categorie constructor.
     * @param $nom
     * @throws Exception
     */
    public function __construct($nom){
        EntityAbstract::isNotEmpty($nom);
        $this->nom = $nom;
    }

    /**
     * @param String $nom
     * @return $this
     * @throws Exception
     */
    public static function fromString(String $nom):self{
        return new self($nom);
    }

    public function getCategorieNom(){
        return $this->nom;
    }
}