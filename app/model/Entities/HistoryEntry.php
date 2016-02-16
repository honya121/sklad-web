<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\HistoryRepository")
 */
class HistoryEntry
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $state;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /**
     * @ORM\Column(type="text")
     */
    private $user;
    
    /**
     * @ORM\Column(type="text")
     */
    private $part;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $level;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $position;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $amount;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getState()
    {
        return $this->state;
    }
    public function setState($state)
    {
        $this->state = $state;
    }
    
    public function getCreated()
    {
        return $this->created;
    }
    public function setCreated($created)
    {
        $this->created = $created;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    public function getPart()
    {
        return $this->part;
    }
    public function setPart($part)
    {
        $this->part = $part;
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
    
    public function getAmount()
    {
        return $this->amount;
    }
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}
