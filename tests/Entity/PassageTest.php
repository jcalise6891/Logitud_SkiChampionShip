<?php

namespace Entity;

use App\Entity\Passage;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class PassageTest extends TestCase
{
    public function testAddPassageSuccessfully()
    {
        $passageTest = new Passage();
        $passageTest->addTime(new DateTime('00:03:15'));
        $passageList = $passageTest->getTime();
        $firstPassage = $passageList[0];
        self::assertInstanceOf(DateTime::class, $firstPassage);
    }

    public function testShouldNotHaveMoreThanTwoPassage()
    {
        $this->expectException(Exception::class);
        $passageTest = new Passage();
        $passageTest->addTime(new DateTime('00:03:15'));
        $passageTest->addTime(new DateTime('00:03:15'));
        $passageTest->addTime(new DateTime('00:03:15'));
    }
}
