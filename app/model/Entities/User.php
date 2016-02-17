<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\UserRepository")
 */
class User extends Nette\Object
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="text")
     */
    private $username;
     
    /**
     * @ORM\Column(type="text")
     */
    private $passwordHash;
    
    /**
     * @ORM\Column(type="text")
     */
    private $role;
    
    /**
     * @ORM\Column(type="text")
     */
    private $name;
    
    /**
     * @ORM\Column(type="text")
     */
    private $email;
    
    /**
     * @ORM\OneToMany(targetEntity="QueueEntry", mappedBy="user")
     */
    private $queueEntries;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }
    
    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getEmail()
    {
        return $this->email;    
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getQueueEntries()
    {
        return $this->queueEntries;
    }
}
