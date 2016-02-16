<?php

namespace App\Model\Facade;

use Doctrine\ORM\EntityManager;

class SocketFacade
{
    private $repository;
    
    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository('App\Model\Entity\Socket');
    }
}