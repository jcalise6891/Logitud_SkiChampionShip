<?php

namespace App\Entity;

use App\Utility\EntityAbstract;
use Exception;

class Profil extends EntityAbstract
{
    /**
     * @var String
     */
    private string $nom;
    private int $ID;

    /**
     * Profil constructor.
     * @param $nom
     * @throws Exception
     */
    public function __construct($id,$nom)
    {
        $this->ID = $id;
        EntityAbstract::isNotEmpty($nom);
        $this->nom = $nom;
    }

    /**
     * @param String $nom
     * @return $this
     * @throws Exception
     */
    public static function fromString(int $ID,string $nom): self
    {
        return new self($ID,$nom);
    }

    /**
     * @return String
     */
    public function getProfilNom()
    {
        return $this->nom;
    }

    public function getID()
    {
        return $this->ID;
    }
}
