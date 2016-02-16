<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\QueueRepository")
 */
 class QueueEntry
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="queueEntries")
     */
     private $user;
     
     /**
     * @ORM\ManyToOne(targetEntity="Part", inversedBy="queueEntries")
     */
     private $part;
     
     /**
     * @ORM\ManyToOne(targetEntity="Socket", inversedBy="queueEntries")
     */
     private $socket;
     
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
     public function setUser(User $user)
     {
         $this->user = $user;
     }
     
     public function getPart()
     {
         return $this->part;
     }
     public function setPart(Part $part)
     {
         $this->part = $part;
     }
     
     public function getSocket()
     {
         return $this->socket;
     }
     public function setSocket(Socket $socket)
     {
         $this->socket = $socket;
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