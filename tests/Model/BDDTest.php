<?php

namespace Model;

use App\Model\BDD;
use Exception;
use PDO;
use PHPUnit\Framework\TestCase;

class BDDTest extends TestCase
{
    public function testConnectionIsValid()
    {
        $PDOMock = $this->createMock(PDO::class);
        $this->assertInstanceOf(
            BDD::class,
            new BDD($PDOMock)
        );
    }

    public function testObjectIsUnknown()
    {

        $PDOMock = $this->createMock(PDO::class);
        $BDDTest = new BDD($PDOMock);
        $objectMock = $this->createMock(\DateTime::class);

        $this->expectException(Exception::class);
        $BDDTest->addToBDD($PDOMock, $objectMock);
    }


}
