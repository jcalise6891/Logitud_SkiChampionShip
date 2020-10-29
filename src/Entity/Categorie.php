<?php

namespace App\Entity;

use App\Utility\EntityAbstract;
use Exception;

class Categorie extends EntityAbstract
{
    private int $ID;
    private string $nom;

    /**
     * Categorie constructor.
     * @param $nom
     * @throws Exception
     */
    public function __construct($ID, $nom)
    {
        $this->ID = $ID;
        EntityAbstract::isNotEmpty($nom);
        $this->nom = $nom;
    }

    /**
     * @param int $id
     * @param String $nom
     * @return $this
     * @throws Exception
     */
    public static function fromString(int $id, string $nom): self
    {
        return new self($id, $nom);
    }

    public function getCategorieNom(): string
    {
        return $this->nom;
    }

    public function getID(): int
    {
        return $this->ID;
    }
}
