<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\PartAttributeRepository")
 */
class PartAttribute extends Nette\Object
{
    /**
     * @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Part", inversedBy="partAttributes")
     */
    private $part;

    /**
     * @ORM\ManyToOne(targetEntity="Attribute")
     */
    private $attribute;


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
 * Get the value of Value
 *
 * @return mixed
*/
public function getValue()
{
    return $this->value;
}

      /**
 * Set the value of Value
 *
 * @param mixed value
*/
public function setValue($value)
{
    $this->value = $value;
}

      /**
 * Get the value of Part
 *
 * @return mixed
*/
public function getPart()
{
    return $this->part;
}

      /**
 * Set the value of Part
 *
 * @param mixed part
*/
public function setPart($part)
{
    $this->part = $part;
}

      /**
 * Get the value of Attribute
 *
 * @return mixed
*/
public function getAttribute()
{
    return $this->attribute;
}

      /**
 * Set the value of Attribute
 *
 * @param mixed attribute
*/
public function setAttribute($attribute)
{
    $this->attribute = $attribute;
}

      }
