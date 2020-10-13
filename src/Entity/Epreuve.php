<?php


namespace App\Entity;

use App\Utility\EntityAbstract;
use DateTime;
use Exception;

class Epreuve extends EntityAbstract
{
    private string $nom;
    private DateTime $date;

    /**
     * @param String $nom
     * @param DateTime $date ;
     * @throws Exception;
     */
    public function __construct(String $nom, DateTime $date)
    {
        EntityAbstract::isNotEmpty($nom);
        $this->nom = $nom;
        EntityAbstract::IsOutOfDate($date);
        $this->date = $date;
    }

    /**
     * @param String $nom
     * @param DateTime $date
     * @return static
     * @throws Exception
     */
    public static function fromString(String $nom, DateTime $date) :self
    {
        return new self($nom, $date);
    }


}
