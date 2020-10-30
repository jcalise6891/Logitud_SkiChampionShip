<?php

namespace App\Model;

use App\Controller\AbstractMainController;
use App\Entity\Personne;
use App\Utility\EntityAbstract;
use Exception;
use PDO;

class PersonneModel extends AbstractMainController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param array $aPersonne
     * @return Personne
     * @throws Exception
     */
    public function arrayToPersonne(array $aPersonne): Personne
    {
        $m_categorie = new CategorieModel($this->pdo);
        $m_profil = new ProfilModel($this->pdo);
        $m_BDD = new BDD($this->pdo);
        return new Personne(
            $m_BDD->getLastIDFromEntity('personne')['ID'] + 1,
            $aPersonne['personneNom'],
            $aPersonne['personnePrenom'],
            $aPersonne['personneMail'],
            EntityAbstract::strToDate($aPersonne['personneDDN']),
            $m_profil->retrieveProfilFromString($aPersonne['personneProfil']),
            $m_categorie->retrieveCategorieFromString($aPersonne['personneCategory'])
        );
    }

    /**
     * @param string $epreuveID
     * @param string $personneID
     * @return bool
     * @throws Exception
     */
    public function deletePersonneFromEpreuve(string $epreuveID, string $personneID)
    {
        $sql = "DELETE FROM personne_epreuve WHERE personne_ID = :p_ID AND epreuve_ID = :e_ID";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':p_ID', $personneID);
        $query->bindValue(':e_ID', $epreuveID);
        if ($query->execute()) {
            $sql_2 = "DELETE FROM personne WHERE ID = :p_ID";
            $query = $this->pdo->prepare($sql_2);
            $query->bindValue(':p_ID', $personneID);
            if ($query->execute()) {
                return true;
            }
        }
        throw new Exception('Une erreur est survenue lors de la suppresion de la personne.');
    }

    public function getSinglePersonne(string $id): Personne
    {
        $sql = "SELECT * FROM personne WHERE ID = :ID";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':ID',$id);
        $query->execute();

        return $this->arrayToPersonne($query->fetch(PDO::FETCH_ASSOC));
    }
}
