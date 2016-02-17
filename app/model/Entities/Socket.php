<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\SocketRepository")
 */
class Socket extends Nette\Object
 {
    /**
     * @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $level;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $position;
    
    /**
     * @ORM\ManyToOne(targetEntity="Part", inversedBy="sockets")
     */
    private $part;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $amount;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $available;
    
    /**
     * @ORM\OneToMany(targetEntity="QueueEntry", mappedBy="socket")
     */
    private $queueEntries;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getLevel()
    {
        return $this->level;
    }
    public function setLevel($level)
    {
        $this->level = $level;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    public function setPosition($position)
    {
        $this->position = $position;
    }
    
    public function getPart()
    {
        return $this->part;
    }
    public function setPart(Part $part = null)
    {
        $this->part = $part;
    }
    
    public function getAmount()
    {
        return $this->amount;
    }
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
    public function getAvailable()
    {
        return $this->available;
    }
    public function setAvailable($available)
    {
        $this->available = $available;
    }
    public function getQueueEntries()
    {
        return $this->queueEntries;
    }
 }