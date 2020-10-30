<?php


namespace App\Model;


use PDO;
use League\Csv;

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

    public function createCSV(string $idEpreuve):string{
        return "TODO::Feuille CSV concernant l'épreuve : ".$idEpreuve;
    }
}