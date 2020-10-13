<?php

namespace Entity;

use App\Entity\Categorie;
use App\Entity\Profil;
use DateTime;
use PHPUnit\Framework\TestCase;
use App\Entity\Personne;

class PersonneTest extends TestCase
{
    public function testPersonneIsValid(){
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
}
