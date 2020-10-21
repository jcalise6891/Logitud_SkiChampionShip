<?php

namespace Entity;

use App\Entity\Categorie;
use PHPUnit\Framework\TestCase;

class CategorieTest extends TestCase
{
    public function testCategorieIsValid()
    {
        $this->assertInstanceOf(
            Categorie::class,
            Categorie::fromString(15,'CategorieTest')
        );
    }

    public function testCategorieIsInvalid()
    {
        $this->expectException(\Exception::class);
        Categorie::fromString(15,'');
    }
}
