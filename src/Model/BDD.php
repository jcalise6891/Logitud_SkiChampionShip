<?php

namespace App\Model;

use App\Utility\EntityAbstract;
use Exception;
use PDO;
use PDOException;

class BDD extends EntityAbstract
{
    private string $db;
    private string $dbHost;
    private int $dbPort;
    private string $dbUser;
    private string $dbPass;

    /**
     * BDD constructor.
     * @param String $db
     * @param String $dbHost
     * @param int $dbPort
     * @param String $dbUser
     * @param String $dbPass
     * @throws Exception
     */
    public function __construct(string $db, string $dbHost, int $dbPort, string $dbUser, string $dbPass)
    {
        EntityAbstract::isNotEmpty($db);
        $this->db = $db;
        $this->dbHost = $dbHost;
        $this->dbPort = $dbPort;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
    }

    /**
     * @param string $db
     * @param string $dbHost
     * @param int $dbPort
     * @param string $dbUser
     * @param string $dbPass
     * @return BDD
     * @throws Exception
     */
    public static function fromString(string $db, string $dbHost, int $dbPort, string $dbUser, string $dbPass)
    {
        return new self($db, $dbHost, $dbPort, $dbUser, $dbPass);
    }

    /**
     * @return false|PDO
     */
    public function connectToBDD()
    {
        try {
            return new PDO(
                'mysql:host=' . $this->dbHost . ';port=' . $this->dbPort . ';dbname=' . $this->db . '',
                $this->dbUser,
                $this->dbPass
            );
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * @param PDO $pdo
     * @param string $entityName
     * @return array
     */
    public function getEntityListFromBDD(PDO $pdo, string $entityName): array
    {
        $sql = 'SELECT * FROM ' . $entityName;
        $query = $pdo->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param PDO $pdo
     * @param object $object
     * @return bool
     * @throws Exception
     */
    public function addToBDD(PDO $pdo, object $object):bool
    {
        $stringClass = get_class($object);
        $exploded = explode('\\', $stringClass);
        switch (end($exploded)) {
            case 'Profil':
                $sql = "INSERT INTO profil (nom) VALUES (:nom)";
                $query = $pdo->prepare($sql);
                $query->bindValue(':nom', $object->getProfilNom());
                return $query->execute();
            case 'Categorie':
                $sql = "INSERT INTO categorie (nom) VALUES (:nom)";
                $query = $pdo->prepare($sql);
                $query->bindValue(':nom', $object->getCategorieNom());
                return $query->execute();
            case 'Personne':
                $sql = "INSERT INTO personne (nom, prenom, mail, dateDeNaissance, categorie, profil)
                        VALUES (:nom, :prenom, :mail, :dateDeNaissance, :categorie, :profil)";
                $query = $pdo->prepare($sql);
                $query->bindValue(':nom', $object->getNom(),PDO::PARAM_STR);
                $query->bindValue(':prenom', $object->getPrenom(),PDO::PARAM_STR);
                $query->bindValue(':mail', $object->getMail(),PDO::PARAM_STR);
                $query->bindValue(':dateDeNaissance', $object->getDateDeNaissance->format('Y-m-d'));
                $query->bindValue(':categorie',$object->getCategorie()->getID());
                $query->bindValue(':profil', $object->getProfil()->getID());
            case 'Epreuve':
                $sql = "INSERT INTO epreuve (nom, date) VALUES (:nom, :date)";
                $query = $pdo->prepare($sql);
                $query->bindValue(':nom', $object->getNom(), PDO::PARAM_STR);
                $query->bindValue(':date', $object->getDate()->format('Y-m-d:H:i'));
                return $query->execute();
            default:
                throw new Exception('No valid object to add');
        }
    }

    public function deleteFromBDD(PDO $pdo, string $id, string $entity): bool
    {
        $sql = 'DELETE FROM ' . $entity . ' WHERE ID = :id';
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

    public function updateToBDD(): bool
    {
        return true;
    }
}
