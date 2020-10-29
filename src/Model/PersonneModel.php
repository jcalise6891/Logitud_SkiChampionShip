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
        return new Personne(
            random_int(0, PHP_INT_MAX),
            $aPersonne['personneNom'],
            $aPersonne['personnePrenom'],
            $aPersonne['personneMail'],
            EntityAbstract::strToDate($aPersonne['personneDDN']),
            $m_profil->retrieveProfilFromString($aPersonne['personneProfil']),
            $m_categorie->retrieveCategorieFromString($aPersonne['personneCategory'])
        );
    }
}