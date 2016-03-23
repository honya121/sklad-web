<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\AttributeRepository")
 */
class Attribute extends Nette\Object
{
    /**
     * @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $unit;

/**
 * Get the value of Id
 *
 * @return mixed
*/
public function getId()
{
    return $this->id;
}

      /**
 * Get the value of Name
 *
 * @return mixed
*/
public function getName()
{
    return $this->name;
}

      /**
 * Set the value of Name
 *
 * @param mixed name
*/
public function setName($name)
{
    $this->name = $name;
}

      /**
 * Get the value of Unit
 *
 * @return mixed
*/
public function getUnit()
{
    return $this->unit;
}

      /**
 * Set the value of Unit
 *
 * @param mixed unit
*/
public function setUnit($unit)
{
    $this->unit = $unit;
}

      }
