<?php

namespace App\Model\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use App\Model\Entity;

class SocketRepository extends EntityRepository
{
    public function findOccupied()
    {
        $q = $this->_em->createQuery('SELECT s FROM App\Model\Entity\Socket s WHERE s.part != 0');
        $sockets = $q->getResult();
        return $sockets;
    }
}
