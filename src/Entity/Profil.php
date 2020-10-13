<?php


namespace App\Entity;

use App\Utility\EntityAbstract;
use Exception;

class Profil extends EntityAbstract
{
    /**
     * @var String
     */
    private String $nom;

    /**
     * Profil constructor.
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

    /**
     * @return String
     */
    public function getNom(){
        return $this->nom;
    }
}