<?php


namespace App\Model;


use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
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

    /**
     * @param string $idEpreuve
     * @return string
     * @throws CannotInsertRecord
     * @throws Exception
     */
    public function createCSV(string $idEpreuve): string
    {
        $sql = "select distinct p.ID, p.nom, p.prenom, p.mail 
                from personne p, epreuve e, personne_epreuve pe
                where p.ID = pe.personne_ID 
                and :idEpreuve = pe.epreuve_ID";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':idEpreuve', $idEpreuve);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $csv= Writer::createFromFileObject(new SplTempFileObject());
        $csv->setDelimiter(';');
        $csv->insertOne(['ID', 'Nom', 'Prenom','Mail','Passage_1','Passage_2']);
        $csv->insertAll($result);

        $csv->output('Epreuve-'.$idEpreuve.'.csv');

        die();
    }

    public function putCSVinBDD(string $idEpreuve)
    {
        /**
         *  TODO:: Create For Each Line of the CSV an object Personne
         *  TODO:: Create -> Passage
         *  TODO:: Insert Passage into DB
         *  TODO:: Insert ID_Passage and ID_Personne
         */

        $m_personne = new PersonneModel($this->pdo);
        $m_BDD = new BDD($this->pdo);

    }
}