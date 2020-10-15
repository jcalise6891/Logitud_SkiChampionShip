<?php

namespace Model;

use App\Entity\Categorie;
use App\Model\BDD;
use Exception;
use PDO;
use PHPUnit\Framework\TestCase;

class BDDTest extends TestCase
{
    public function testConnectionIsValid(){
        $this->assertInstanceOf(
            BDD::class,
            BDD::fromString('test','localhost',3307,'root','root')
        );
    }

    public function testConnectionIsInvalid(){
        $this->expectException(Exception::class);
        BDD::fromString(' ','',52,'','');
    }

    public function testObjectIsKnown(){
        $BDDTest = new BDD('test','test','52','root','root');
        $PDOMock = $this->createMock(PDO::class);
        $catTest = new Categorie('catTest');
        $this->assertIsString($BDDTest->addToBDD($PDOMock, $catTest));
    }

    public function testObjectIsUnknown(){
        $BDDTest = new BDD('test','test','52','root','root');
        $PDOMock = $this->createMock(PDO::class);
        $objectMock =$this->createMock(\DateTime::class);

        $this->expectException(Exception::class);
        $BDDTest->addToBDD($PDOMock, $objectMock);
    }


}
