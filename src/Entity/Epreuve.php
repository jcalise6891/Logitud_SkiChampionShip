<?php

namespace App\Entity;

use App\Utility\EntityAbstract;
use DateTime;
use Exception;

class Epreuve extends EntityAbstract
{
    private string $nom;
    private DateTime $date;
    private array $participants = [];

    /**
     * @param String $nom
     * @param DateTime $date ;
     * @throws Exception;
     */
    public function __construct(string $nom, DateTime $date)
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
    public static function fromString(string $nom, DateTime $date): self
    {
        return new self($nom, $date);
    }

    /**
     * @return String
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @return array
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }

    /**
     * @param Personne $personne
     * @throws Exception
     */
    public function addParticipant(Personne $personne)
    {
        if (array_search($personne, $this->participants) === false) {
            array_push($this->participants, $personne);
        } else {
            throw new Exception('Cette personne participe déjà à cette Epreuve');
        }
    }

    /**
     * @param Personne $personne
     * @throws Exception
     */
    public function deleteParticipant(Personne $personne)
    {
        if ($index = array_search($personne, $this->participants) !== false) {
            unset($this->participants[$index]);
        } else {
            throw new Exception("Cette personne ne participe pas à cette épreuve");
        }
    }
}
