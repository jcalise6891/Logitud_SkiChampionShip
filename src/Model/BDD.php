<?php

namespace App\Model;

use App\Utility\EntityAbstract;
use Exception;
use PDO;

class BDD extends EntityAbstract
{
    private PDO $PDO;

    /**
     * BDD constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->PDO = $pdo;
    }

    /**
     * @param PDO $pdo
     * @param string $entityName
     * @return array
     */
    public function getEntityListFromBDD(string $entityName): array
    {
        $sql = 'SELECT * FROM ' . $entityName;
        $query = $this->PDO->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListFromSpecificOption(string $entityName, string $entityCondition, int $entityConditionID)
    {
        $sql = 'SELECT ' . $entityName . '.* FROM ' . $entityName . ', ' . $entityName . '_' . $entityCondition .
            ' WHERE ' . $entityName . '_' . $entityCondition . '.' . $entityName . '_ID = ' . $entityName .
            '.ID AND ' . $entityName . '_' . $entityCondition . '.' . $entityCondition . '_ID = ' . $entityConditionID;
        $query = $this->PDO->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param PDO $pdo
     * @param object $object
     * @return bool
     * @throws Exception
     */
    public function addToBDD(object $object): bool
    {
        $stringClass = get_class($object);
        $exploded = explode('\\', $stringClass);
        switch (end($exploded)) {
            case 'Profil':
                $sql = "INSERT INTO profil (nom) VALUES (:nom)";
                $query = $this->PDO->prepare($sql);
                $query->bindValue(':nom', $object->getProfilNom());
                return $query->execute();
            case 'Categorie':
                $sql = "INSERT INTO categorie (nom) VALUES (:nom)";
                $query = $this->PDO->prepare($sql);
                $query->bindValue(':nom', $object->getCategorieNom());
                return $query->execute();
            case 'Personne':
                $sql = "INSERT INTO personne (ID, nom, prenom, mail, dateDeNaissance, categorie, profil)
                        VALUES (:ID, :nom, :prenom, :mail, :dateDeNaissance, :categorie, :profil)";
                $query = $this->PDO->prepare($sql);
                $query->bindValue(':ID', $object->getID(), PDO::PARAM_INT);
                $query->bindValue(':nom', $object->getNom(), PDO::PARAM_STR);
                $query->bindValue(':prenom', $object->getPrenom(), PDO::PARAM_STR);
                $query->bindValue(':mail', $object->getMail(), PDO::PARAM_STR);
                $query->bindValue(':dateDeNaissance', $object->getDateDeNaissance()->format('Y-m-d'), PDO::PARAM_STR);
                $query->bindValue(':categorie', $object->getCategorie()->getID());
                $query->bindValue(':profil', $object->getProfil()->getID());
                return $query->execute();
            case 'Epreuve':
                $sql = "INSERT INTO epreuve (nom, date) VALUES (:nom, :date)";
                $query = $this->PDO->prepare($sql);
                $query->bindValue(':nom', $object->getNom(), PDO::PARAM_STR);
                $query->bindValue(':date', $object->getDate()->format('Y-m-d:H:i'));
                return $query->execute();
            default:
                throw new Exception('No valid object to add');
        }
    }

    public function deleteFromBDD(string $id, string $entity): bool
    {
        $sql = 'DELETE FROM ' . $entity . ' WHERE ID = :id';
        $query = $this->PDO->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
}
