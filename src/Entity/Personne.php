<?php

namespace App\Entity;

use App\Utility\EntityAbstract;
use DateTime;
use Exception;

class Personne extends EntityAbstract
{

    private int $ID;
    private string $nom;
    private string $prenom;
    private string $mail;
    private DateTime $dateDeNaissance;
    private Profil $profil;
    private Categorie $categorie;
    private Passage $passage;
    private string $image;


    /**
     * Personne constructor.
     * @param int $ID
     * @param String $nom
     * @param String $prenom
     * @param String $mail
     * @param DateTime $dateDeNaissance
     * @param Profil $profil
     * @param Categorie $categorie
     * @param String $image = "default"
     * @throws Exception
     */
    public function __construct(
        int $ID,
        string $nom,
        string $prenom,
        string $mail,
        DateTime $dateDeNaissance,
        Profil $profil,
        Categorie $categorie,
        string $image = "default"
    ) {
        EntityAbstract::isNotEmpty($ID);
        $this->ID = $ID;

        EntityAbstract::isNotEmpty($nom);
        $this->nom = $nom;

        EntityAbstract::isNotEmpty($prenom);
        $this->prenom = $prenom;

        EntityAbstract::IsMailValid($mail);
        $this->mail = $mail;

        EntityAbstract::isBirthDateValid($dateDeNaissance);
        $this->dateDeNaissance = $dateDeNaissance;

        $this->profil = $profil;
        $this->categorie = $categorie;
    }

    /**
     * @return String
     */
    public function getCategorie(): string
    {
        return $this->categorie->getCategorieNom();
    }

    /**
     * @return String
     */
    public function getProfil(): string
    {
        return $this->profil->getProfilNom();
    }

    /**
     * @return String
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return String
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @return String
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @return DateTime
     */
    public function getDateDeNaissance(): DateTime
    {
        return $this->dateDeNaissance;
    }

    /**
     * @return String
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return array
     */
    public function getPassage(): array
    {
        $this->passage->getTime();
    }

    /**
     * @throws Exception
     */
    public function setPassage()
    {
        $this->passage->addTime();
    }
}
