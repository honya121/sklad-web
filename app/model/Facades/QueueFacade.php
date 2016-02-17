<?php

namespace App\Model\Facade;

use Doctrine\ORM\EntityManager;
use App\Model\Entity;
use DateTime;
class QueueFacade
{
    private $repository;
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository('App\Model\Entity\QueueEntry');
        $this->em = $em;
    }
    
    public function get($id)
    {
        return $this->repository->find($id);
    }
    
    public function request(Entity\Socket $socket,
                            Entity\User $user,
                            $amount)
    {
        $entry = new Entity\QueueEntry;
        $entry->state = 0;
        $entry->created = new DateTime('now');
        $entry->user = $user;
        $entry->part = $socket->getPart();
        $entry->socket = $socket;
        $entry->amount = $amount;
        $this->em->persist($entry);
        
        $socket->available -= $amount;
        
        $this->em->flush();
        
    }
    public function getQueueTable()
    {
        $queueEntries = $this->repository->findAll();
        $queueTable = array();
        foreach($queueEntries as $queueEntry)
        {
            $queueTable[] = array(
                'id' => $queueEntry->id,
                'state' => $queueEntry->state,
                'created' => $queueEntry->created,
                'user_id' => $queueEntry->user->id,
                'user_username' => $queueEntry->user->username,
                'part_id' => $queueEntry->part->id,
                'part_name' => $queueEntry->part->name,
                'socket_id' => $queueEntry->socket->id,
                'socket_position' => $queueEntry->socket->position,
                'socket_level' => $queueEntry->socket->level,
                'amount' => $queueEntry->amount
            );
        }
        return $queueTable;
    }
    
    public function deleteQueueEntry($queueEntryId)
    {
        $queueEntry = $this->get($queueEntryId);
        
        $queueEntry->socket->available += $queueEntry->amount;
        
        $this->em->remove($queueEntry);
        $this->em->flush();
    }
    
}