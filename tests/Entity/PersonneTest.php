<?php

namespace Entity;

use App\Entity\Categorie;
use App\Entity\Personne;
use App\Entity\Profil;
use DateTime;
use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;

class PersonneTest extends TestCase
{


    public function testPersonneIsValid()
    {
        $dateTest = new DateTime('yesterday');
        $profilTest = new Profil('ProfilTest');
        $categorieTest = new Categorie('CategorieTest');

        $testPersonne = new Personne(
            'Jean-Test',
            'Michel-Test',
            'jeanmichel@test.com',
            $dateTest,
            $profilTest,
            $categorieTest
        );

        $this->assertInstanceOf(Personne::class,
            $testPersonne);
    }


    public function testPersonneIsInvalid()
    {

        $this->expectException(Exception::class);

        $dateTest = new DateTime('yesterday');
        $profilTest = new Profil('ProfilTest');
        $categorieTest = new Categorie('CategorieTest');

        $testPersonne = new Personne(
            '',
            'Michel-Test',
            'jeanmichel@test.com',
            $dateTest,
            $profilTest,
            $categorieTest
        );
    }

    /**
     * @param $nom
     * @param $prenom
     * @param $mail
     * @param $birthdate
     * @param $profil
     * @param $categorie
     * @throws Exception
     * @dataProvider provider
     */
    public function testPersonneBirthdateIsInvalid($nom, $prenom, $mail, $birthdate, $profil, $categorie)
    {
        $this->expectException(Exception::class);
        $personne = new Personne($nom, $prenom, $mail, $birthdate, $profil, $categorie);
        fwrite(STDERR, print_r($personne, TRUE));
    }

    public function provider()
    {
        $dateTestarray = new DateTimeImmutable();
        $profilTest = new Profil('ProTest');
        $categorieTest = new Categorie('CatTest');

        return array(
            array(
                'Jean-Michel',
                'test',
                'jeanmichel@test.com',
                (new DateTime)->setDate(1891, 05, 28),
                $profilTest,
                $categorieTest
            ),
            array(
                'Jean-Michel',
                'Test',
                'jeanmichel@test.com',
                (new DateTime)->setDate(2050, 02, 15),
                $profilTest,
                $categorieTest
            )
        );
    }
}
