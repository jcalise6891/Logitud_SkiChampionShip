<?php


namespace App\Model;


use League\Csv\Writer;
use PDO;
use SplTempFileObject;

class CSVModel
{

    /**
     * @var PDO
     */
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createCSV(string $idEpreuve): string
    {
        $sql = "select p.ID, p.nom, p.prenom, p.mail 
                from personne p, epreuve e, personne_epreuve pe
                where p.ID = pe.personne_ID 
                and :idEpreuve = pe.epreuve_ID";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':idEpreuve', $idEpreuve);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $csv= Writer::createFromFileObject(new SplTempFileObject());

        $csv->insertOne(['ID', 'Nom', 'Prenom','Mail','Passage_1','Passage_2']);

        $csv->insertAll($result);

        return $csv->output('Epreuve-'.$idEpreuve.'.csv');
    }

    public function putCSVinBDD(string $idEpreuve)
    {

    }
}