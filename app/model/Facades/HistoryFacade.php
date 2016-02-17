<?php

namespace App\Model\Facade;

use Doctrine\ORM\EntityManager;
use App\Model\Entity;
use DateTime;
class HistoryFacade
{
    private $em;
    private $repository;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('App\Model\Entity\HistoryEntry');
    }
    
    public function get($id)
    {
        return $this->repository->find($id);
    }
    
    public function addFill($socketId, $amount, $userId)
    {
        $historyEntry = new Entity\HistoryEntry;
        $socket = $this->em->getRepository('App\Model\Entity\Socket')->find($socketId);
        $user = $this->em->getRepository('App\Model\Entity\User')->find($userId);
        $historyEntry->state = -1;
        $historyEntry->created = new DateTime('now');
        $historyEntry->user = $user->username;
        $historyEntry->part = $socket->part->name;
        $historyEntry->level = $socket->level;
        $historyEntry->position = $socket->position;
        $historyEntry->amount = $amount - $socket->amount;
        $this->em->persist($historyEntry);
        $this->em->flush();
    }
    
    public function addWithdraw($socketId, $amount, $userId)
    {
        $historyEntry = Entity\HistoryEntry;
        $socket = $this->em->getRepository('App\Model\Entity\Socket')->find($socketId);
        $user = $this->em->getRepository('App\Model\Entity\User')->find($userId);
        $historyEntry->state = 1;
        $historyEntry->created = new DateTime('now');
        $historyEntry->user = $user->username;
        $historyEntry->part = $socket->part->name;
        $historyEntry->level = $socket->level;
        $historyEntry->position = $socket->position;
        $historyEntry->amount = $amount;
        $this->em->persist($historyEntry);
        $this->em->flush();
    }
    
    public function getHistoryTable()
    {
        $historyEntries = $this->repository->findAll();
        $historyTable = array();
        foreach($historyEntries as $historyEntry)
        {
            $historyTable[] = array(
                'id' => $historyEntry->id,
                'type' => (($historyEntry->state == -1) ? 'doplnění' : 'výběr'),
                'state' => $historyEntry->state,
                'created' => $historyEntry->created,
                'user' => $historyEntry->user,
                'part' => $historyEntry->part,
                'position' => $historyEntry->position,
                'level' => $historyEntry->level,
                'amount' => $historyEntry->amount
            );
        }
        
        return $historyTable;
    }
}