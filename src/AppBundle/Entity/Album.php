<?php
// src/AppBundle/Entity/Album.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Entity
 */
class Album implements JsonSerializable {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    // één Album heeft meerdere Audio, Audio hebben één Album
    /**
     * @ORM\OneToMany(targetEntity="Audio", mappedBy="album")
     */
    private $audioItems;

    // één User heeft meerdere Albums, één Album heeft één User
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="albums")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    public function __construct() {
        $this->audioItems = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAudioItems()
    {
        return $this->audioItems;
    }

    /**
     * @param mixed $audioItems
     */
    public function setAudioItems($audioItems)
    {
        $this->audioItems = $audioItems;
    }

    /**
     * @param \AppBundle\Entity\Audio $audio
     */
    public function setAudio(\AppBundle\Entity\Audio $audio){
        /* setting the album on the Audio*/
        $audio->setAlbum($this);
        /* adding the Audio to the arrayCollection*/
        $this->audioItems->add($audio);
    }

    /**
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \AppBundle\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /* function that gets used when calling json_encode on objects*/
    public function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'tracks' => $this->audioItems->getValues()
        ];
    }

}