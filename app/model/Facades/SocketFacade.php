<?php

namespace App\Model\Facade;

use Doctrine\ORM\EntityManager;
use App\Model\Entity;

class SocketFacade
{
    private $em;
    private $repository;
    private $historyFacade;
    
    public function __construct(EntityManager $em, HistoryFacade $historyFacade)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('App\Model\Entity\Socket');
        $this->historyFacade = $historyFacade;
    }
    
    public function get($id)
    {
        return $this->repository->find($id);
    }
    
    public function getOccupiedSocketsArray()
    {
        $sockets = $this->repository->findAll();
        $socketsArray = array();
        foreach($sockets as $socket)
        {
            if($socket->part)
            {
                $row = array(
                    'id' => $socket->id,
                    'level' => $socket->level,
                    'position' => $socket->position,
                    'amount' => $socket->amount,
                    'available' => $socket->available
                );  
                if($socket->part)
                {
                    $row['part'] = array(
                        'id' => $socket->part->id,
                        'name' => $socket->part->name,
                    );
                }
                else
                {
                    $row['part'] = null;
                }
                $socketsArray[] = $row;
            }
        }
        return $socketsArray;
    }
    public function getSocketsTable()
    {
        $sockets = $this->repository->findAll();
        $socketsTable = array();
        foreach($sockets as $socket)
        {
            $row = array(
                'id' => $socket->id,
                'level' => $socket->level,
                'position' => $socket->position,
                'amount' => $socket->amount,
                'available' => $socket->available
            );
            if($socket->part)
            {
                $row['part_id'] = $socket->part->id;
                $row['part_name'] = $socket->part->name;
            }
            else
            {
                $row['part_id'] = -1;
                $row['part_name'] = 'prázdné';
            }
            $socketsTable[] = $row;
            
        }
        return $socketsTable;
    }
    
    public function getFreeSocketsTable()
    {
        $sockets = $this->repository->findBy(array('part' => null));
        $socketsTable = array();
        foreach($sockets as $socket)
        {
            $socketsTable[] = array(
                'id' => $socket->id,
                'level' => $socket->level,
                'position' => $socket->position
            );
        }
        return $socketsTable;
    }
    
    public function initialize()
    {
        for($i = 1; $i <= 70; ++$i)
        {
            $socket = new Entity\Socket;
            $socket->level = 1;
            $socket->position = $i;
            $socket->part = null;
            $socket->amount = 0;
            $socket->available = 0;
            $this->em->persist($socket);
        }
        $this->em->flush();
    }
    
    public function assignPart($socketId, $partId)
    {
        $socket = $this->get($socketId);
        $part = $this->em->getRepository('App\Model\Entity\Part')->find($partId);
        $socket->part = $part;
        $this->em->flush();
    }
    public function fillSocket($socketId, $amount, $userId)
    {
        $socket = $this->get($socketId);
        if($amount > $socket->amount - $socket->available)
        {
            $this->historyFacade->addFill($socketId, $amount, $userId);
            $socket->available = $amount - ($socket->amount - $socket->available);
            $socket->amount = $amount;
           
            $this->em->flush();
        }
        return FALSE;
    }
    public function freeSocket($socketId)
    {
        $socket = $this->get($socketId);
        $socket->amount = 0;
        $socket->available = 0;
        $socket->part = null;
        $this->em->flush();
    }
}