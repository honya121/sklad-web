<?php

namespace App\Model\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findByUsername($username)
    {
        $user = $this->findOneBy(array('username' => $username));
        return $user;
    }
}