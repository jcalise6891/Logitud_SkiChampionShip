<?php


namespace App\Model;


use App\Controller\AbstractMainController;
use App\Entity\Categorie;
use PDO;

class CategorieModel extends AbstractMainController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function retrieveCategorieList(): array
    {
        $sql = "SELECT * FROM categorie";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $nom
     * @return Categorie
     * @throws \Exception
     */
    public function retrieveCategorieFromString(string $nom): Categorie
    {
        $sql = "SELECT * FROM categorie WHERE nom = :nom";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':nom', $nom);
        $query->execute();
        $result = $query->fetch(PDo::FETCH_ASSOC);
        return new Categorie($result['ID'], $result['nom']);
    }
}