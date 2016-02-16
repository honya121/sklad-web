<?php

namespace App\Model\Facade;

use Doctrine\ORM\EntityManager;

class HistoryFacade
{
    private $repository;
    
    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository('App\Model\Entity\HistoryEntry');
    }
}