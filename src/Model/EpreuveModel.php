<?php


namespace App\Model;


use PDO;

class EpreuveModel
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

    public function retrieveEpreuveList(){
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


}