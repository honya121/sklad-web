<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nette;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\PartRepository")
 */
class Part extends Nette\Object
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
     * @ORM\Column(type="float")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="parts")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="PartAttribute", mappedBy="part")
     */
    private $partAttributes;

    /**
     * @ORM\OneToMany(targetEntity="Socket", mappedBy="part")
     */
    private $sockets;

    /**
     * @ORM\OneToMany(targetEntity="QueueEntry", mappedBy="part")
     */
    private $queueEntries;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getWidth()
    {
        return $this->width;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return $this->length;
    }
    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getSockets()
    {
        return $this->sockets;
    }

    public function getQueueEntries()
    {
        return $this->queueEntries;
    }


      /**
 * Get the value of Type
 *
 * @return mixed
*/
public function getType()
{
    return $this->type;
}

      /**
 * Set the value of Type
 *
 * @param mixed type
*/
public function setType($type)
{
    $this->type = $type;
}

      /**
 * Get the value of Part Attributes
 *
 * @return mixed
*/
public function getPartAttributes()
{
    return $this->partAttributes;
}

      /**
 * Set the value of Part Attributes
 *
 * @param mixed partAttributes
*/
public function setPartAttributes($partAttributes)
{
    $this->partAttributes = $partAttributes;
}

      /**
 * Set the value of Sockets
 *
 * @param mixed sockets
*/
public function setSockets($sockets)
{
    $this->sockets = $sockets;
}

      /**
 * Set the value of Queue Entries
 *
 * @param mixed queueEntries
*/
public function setQueueEntries($queueEntries)
{
    $this->queueEntries = $queueEntries;
}

      }
