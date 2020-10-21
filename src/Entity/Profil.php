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

    /**
     * Profil constructor.
     * @param $nom
     * @throws Exception
     */
    public function __construct($nom)
    {
        EntityAbstract::isNotEmpty($nom);
        $this->nom = $nom;
    }

    /**
     * @param String $nom
     * @return $this
     * @throws Exception
     */
    public static function fromString(string $nom): self
    {
        return new self($nom);
    }

    /**
     * @return String
     */
    public function getProfilNom()
    {
        return $this->nom;
    }
}
