<?php


namespace App\Entity;

use DateTime;
use App\Entity\Profil;
use App\Entity\Categorie;
use App\Utility\EntityAbstract;
use Exception;

class Personne extends EntityAbstract
{
    private String $nom;
    private String $prenom;
    private String $mail;
    private DateTime $dateDeNaissance;
    private Profil $profil;
    private Categorie $categorie;

    /**
     * Personne constructor.
     * @param String $nom
     * @param String $prenom
     * @param String $mail
     * @param DateTime $dateDeNaissance
     * @param \App\Entity\Profil $profil
     * @param \App\Entity\Categorie $categorie
     * @throws Exception
     */
    public function __construct(
        string $nom,
        string $prenom,
        string $mail,
        DateTime $dateDeNaissance,
        Profil $profil,
        Categorie $categorie
    )
    {
        EntityAbstract::isNotEmpty($nom);
        $this->nom = $nom;

        EntityAbstract::isNotEmpty($prenom);
        $this->prenom = $prenom;

        EntityAbstract::IsMailValid($mail);
        $this->mail = $mail;

        EntityAbstract::IsBirthDateValid($dateDeNaissance);
        $this->dateDeNaissance = $dateDeNaissance;

        $this->profil = $profil;
        $this->categorie = $categorie;
    }

    /**
     * @return String
     */
    public function getCategorie():string
    {
        return $this->categorie->getNom();
    }

    /**
     * @return String
     */
    public function getProfil():string
    {
        return $this->profil->getNom();
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
}
