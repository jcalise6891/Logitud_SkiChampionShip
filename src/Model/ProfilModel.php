<?php


namespace App\Model;


use App\Controller\AbstractMainController;
use App\Entity\Profil;
use Exception;
use PDO;

class ProfilModel extends AbstractMainController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function retrieveCatagorieList(): array
    {
        $sql = "SELECT * FROM profil";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $nom
     * @return Profil
     * @throws Exception
     */
    public function retrieveProfilFromString(string $nom): Profil
    {
        $sql = "SELECT * FROM profil WHERE nom = :nom";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':nom', $nom);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return new Profil($result['ID'], $result['nom']);
    }
}