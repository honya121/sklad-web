<?php

namespace App\Model\Facade;

use Doctrine\ORM\EntityManager;

class PartFacade
{
    private $repository;
    
    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository('App\Model\Entity\Part');
    }
}