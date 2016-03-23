<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\TypeRepository")
 */
class Type extends Nette\Object
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
     * @ORM\ManyToMany(targetEntity="Attribute")
     */
    private $attributes;

    /**
     * @ORM\OneToMany(targetEntity="Part", mappedBy="type")
     */
    private $parts;


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
 * Get the value of Attributes
 *
 * @return mixed
*/
public function getAttributes()
{
    return $this->attributes;
}

      /**
 * Set the value of Attributes
 *
 * @param mixed attributes
*/
public function setAttributes($attributes)
{
    $this->attributes = $attributes;
}

      /**
 * Get the value of Parts
 *
 * @return mixed
*/
public function getParts()
{
    return $this->parts;
}

      /**
 * Set the value of Parts
 *
 * @param mixed parts
*/
public function setParts($parts)
{
    $this->parts = $parts;
}

      }
