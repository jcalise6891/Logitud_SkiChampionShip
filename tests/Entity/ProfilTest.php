<?php

namespace Entity;

use App\Entity\Profil;
use Exception;
use PHPUnit\Framework\TestCase;

class ProfilTest extends TestCase
{
    public function testProfilIsValid()
    {
        $this->assertInstanceOf(
            Profil::class,
            Profil::fromString(15, 'ProfilTest')
        );
    }

    public function testProfilIsInvalid()
    {
        $this->expectException(Exception::class);
        Profil::fromString(15, '');
    }
}
