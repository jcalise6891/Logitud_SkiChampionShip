<?php

namespace Entity;

use App\Entity\Categorie;
use App\Entity\Epreuve;
use App\Entity\Personne;
use App\Entity\Profil;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class EpreuveTest extends TestCase
{
    /**
     * @test
     */
    public function testEpreuveIsValid()
    {
        $dateTest = new DateTime('today');

        $this->assertInstanceOf(
            Epreuve::class,
            Epreuve::fromString('EpreuveTest', $dateTest)
        );
    }

    public function testEpreuveNameIsInvalid()
    {
        $dateTest = new DateTime();

        $this->expectException(Exception::class);
        Epreuve::fromString('', $dateTest);
    }

    public function testEpreuveDateCannotBeInThePast()
    {
        $dateTest = new DateTime('yesterday');

        $this->expectException(Exception::class);
        Epreuve::fromString('EpreuveTest', $dateTest);
    }

    public function testParticipantIsAdded()
    {
        $epreuveTest = new Epreuve('2020Tournament',new DateTime('tomorrow'));

        $personneTest = new Personne(
            'jean',
            'michel',
            'jean.michel@test.com',
            new DateTime('yesterday'),
            new Profil('profTest'),
            new Categorie('catTest')
        );

        $epreuveTest->addParticipant($personneTest);
        $participantList = $epreuveTest->getParticipants();
        $first = $participantList[0];
        $this->assertInstanceOf(Personne::class,$first);
    }

    public function testShouldNotAddTheSamePerson(){
        $this->expectException(Exception::class);

        $epreuveTest = new Epreuve('2020Tournament',new DateTime('tomorrow'));

        $personneTest = new Personne(
            'jean',
            'michel',
            'jean.michel@test.com',
            new DateTime('yesterday'),
            new Profil('profTest'),
            new Categorie('catTest')
        );

        $epreuveTest->addParticipant($personneTest);
        $epreuveTest->addParticipant($personneTest);
    }

    public function testShouldNotDeleteNonParticipant(){
        $this->expectException(Exception::class);

        $epreuveTest = new Epreuve('2020Tournament',new DateTime('tomorrow'));

        $personneTest = new Personne(
            'jean',
            'michel',
            'jean.michel@test.com',
            new DateTime('yesterday'),
            new Profil('profTest'),
            new Categorie('catTest')
        );

        $epreuveTest->deleteParticipant($personneTest);
    }
}
