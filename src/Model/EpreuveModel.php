<?php


namespace App\Model;


use App\Entity\Epreuve;
use App\Utility\EntityAbstract;
use DateTime;
use Exception;
use PDO;

class EpreuveModel extends EntityAbstract
{
    private PDO $pdo;

    /**
     * EpreuveModel constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function retrieveEpreuveList()
    {
        $sql = "select e.*, count(pe.personne_ID)
                as NbParticipant
                from epreuve e
                left join personne_epreuve pe
                on e.ID = pe.epreuve_ID 
                group by e.ID";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param Epreuve $epreuve
     * @return bool | void
     * @throws Exception
     */
    public function insertIntoBDDNewEpreuve(Epreuve $epreuve)
    {
        if ($oEpreuve = $this->retrieveSingleEpreuve($epreuve->getID())) {
            $oldEpreuve = $this->arrayToEpreuve($oEpreuve);
            if (
                ($oldEpreuve->getDate() < $epreuve->getDate())
                ||
                $oldEpreuve->getNom() != $epreuve->getNom()
            ) {
                $sql = "update epreuve set nom = :nomEpreuve , date = :dateEpreuve where ID = :ID";
                $query = $this->pdo->prepare($sql);
                $query->bindValue(':nomEpreuve', $epreuve->getNom(), PDO::PARAM_STR);
                $query->bindValue(
                    ':dateEpreuve',
                    $epreuve->getDate()->format('Y-m-d:H:i'),
                    PDO::PARAM_STR
                );
                $query->bindValue(':ID', $epreuve->getID(), PDO::PARAM_INT);
                return $query->execute();
            }
        }
        throw new Exception("L'épreuve ne peux pas être placé à une date antérieur");
    }

    /**
     * @param $id
     * @return mixed
     */
    public function retrieveSingleEpreuve($id)
    {
        $sql = "select * from epreuve where epreuve.ID = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $aEpreuve
     * @return Epreuve
     * @throws Exception
     */
    public function arrayToEpreuve(array $aEpreuve)
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $aEpreuve['date']);
        return new Epreuve(
            $aEpreuve['nom'],
            $date
        );
    }

    /**
     * @param $idEpreuve
     * @param int $idPersonne
     * @return bool
     */
    public function insertPersonneToEpreuveIntoBDD($idEpreuve, int $idPersonne)
    {
        $sql = "INSERT INTO personne_epreuve (personne_ID, epreuve_ID) VALUES (:perID, :eprID)";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':perID', $idPersonne);
        $query->bindValue(':eprID', $idEpreuve);
        return $query->execute();
    }


}