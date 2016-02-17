<?php

namespace App\Model\Facade;

use Doctrine\ORM\EntityManager;
use Nette;
use App\Model\Entity\User;

class UserFacade
{
    private $repository;
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('App\Model\Entity\User');
    }
    
    public function get($id)
    {
        return $this->repository->find($id);
    }
    
    public function userExist($username)
    {
       if($this->repository->findByUsername($username))
       {
           return TRUE;
       } 
       else 
       {
           return FALSE;
       }
    }
    
    public function checkUser($username, $password)
    {
        $user = $this->repository->findByUsername($username);
        return Nette\Security\Passwords::verify($password, $user->passwordHash);
    }
    
    public function getUserByUsername($username)
    {
       return $this->repository->findByUsername($username); 
    }
    
    public function addUser($username, 
                            $password, 
                            $role,
                            $name,
                            $email)
    {
        $user = new User;
        $user->username = $username;
        $user->passwordHash = Nette\Security\Passwords::hash($password);
        $user->role = $role;
        $user->name = $name;
        $user->email = $email;
        $this->em->persist($user);
        $this->em->flush();
    }
    
    public function updateUser($userId, $data)
    {
        $user = $this->get($userId);
        $user->username = $data['username'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
       if($data['password'])
       {
           $user->passwordHash = Nette\Security\Passwords::hash($data['password']);
       }
        $this->em->flush();
    }
    
    public function getUsersTable()
    {
        $users = $this->repository->findAll();
        $usersTable = array();
        foreach($users as $user)
        {
            $usersTable[] = array(
                'id' => $user->id,
                'username' => $user->username,
                'passwordHash' => $user->passwordHash,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            );
        }
        return $usersTable;
    }
    
    public function getRolesArray()
    {
        $roles = array(
            'user' => "Uživatel",
            'manager' => "Správce",
            'admin' => "Administrátor"
        );
        return $roles;
    }
    
    public function changePassword($userId, $oldPassword, $newPassword)
    {
        $user = $this->get($userId);
        if(Nette\Security\Passwords::verify($oldPassword, $user->passwordHash))
        {
            $user->passwordHash = Nette\Security\Passwords::hash($newPassword);
            $this->em->flush();
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function deleteUser($userId)
    {
        $user = $this->get($userId);
        $this->em->remove($user);
        $this->em->flush();
    }
}