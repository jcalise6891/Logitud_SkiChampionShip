<?php

namespace App\Entity;

use App\Controller\AbstractMainController;
use App\Utility\EntityAbstract;
use DateTime;
use Exception;

class Passage extends AbstractMainController
{
    private array   $time = [];
    private int     $ID;

    /**
     * Passage constructor.
     * @param int $id
     * @throws Exception
     */
    public function __construct(int $id){
        EntityAbstract::isNotEmpty($id);
        $this->ID = $id;
    }
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

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }
}
