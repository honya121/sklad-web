<?php

namespace App\Model\Facade;

use Doctrine\ORM\EntityManager;
use App\Model\Entity;

class PartFacade
{
    private $em;
    private $repository;
 
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('App\Model\Entity\Part');
    }
    
    public function get($id)
    {
        return $this->repository->find($id);
    }
    public function getPartsTable()
    {
        $parts = $this->repository->findAll();
        $partsArray = array();
        foreach($parts as $part)
        {
            $partsArray[] = array(
                'id' => $part->id,
                'name' => $part->name,
                'width' => $part->width,
                'length' => $part->length,
                'description' => $part->description
            );
        }
        return $partsArray;
    }
    
    public function addPart($data)
    {
        $part = new Entity\Part;
        $part->name = $data['name'];
        $part->width = $data['width'];
        $part->length = $data['length'];
        $part->description = $data['description'];
        $this->em->persist($part);
        $this->em->flush();
    }
    public function updatePart($partId, $data)
    {
        $part = $this->repository->find($partId);
        $part->name = $data['name'];
        $part->width = $data['width'];
        $part->length = $data['length'];
        $part->description = $data['description'];
        $this->em->flush();
    }
    public function deletePart($partId)
    {
        $part = $this->repository->find($partId);
        $this->em->remove($part);
        $this->em->flush();
    }
}