<?php


namespace App\Entity;

use DateTime;
use Exception;

class Passage
{
    private array $time = [];



    /**
     * @return array
     */
    public function getTime(): array
    {
        return $this->time;
    }

    /**
     * @param DateTime $time
     * @throws Exception
     */
    public function addTime(DateTime $time)
    {
        if (count($this->time) < 2) {
            array_push($this->time, $time);
        } else {
            throw new Exception('Ne peux pas faire plus de deux temps');
        }
    }
}
