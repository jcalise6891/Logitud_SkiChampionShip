<?php

namespace Entity;

use App\Entity\Epreuve;
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
}
