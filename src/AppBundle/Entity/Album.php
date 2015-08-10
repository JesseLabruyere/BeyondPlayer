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

    // één Album heeft meerdere AlbumAudioLinks, AlbumAudioLinks hebben één Album
    /**
     * @ORM\OneToMany(targetEntity="AlbumAudioLink", mappedBy="album")
     *
     */
    private $albumItems;

    public function __construct() {
        $this->albumItems = new ArrayCollection();
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
    public function getAlbumItems()
    {
        return $this->albumItems;
    }

    /**
     * @param mixed $albumItems
     */
    public function setAlbumItems($albumItems)
    {
        $this->albumItems = $albumItems;
    }

    /**
     * @param \AppBundle\Entity\AlbumAudioLink $audioLink
     */
    public function addAudio(\AppBundle\Entity\AlbumAudioLink $audioLink){
        /* setting the album on the Audio*/
        $audioLink->setAlbum($this);
        /* adding the Audio to the arrayCollection*/
        $this->albumItems->add($audioLink);
    }

    /* function that gets used when calling json_encode on objects*/
    public function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'count' => count($this->albumItems->getValues()),
            'tracks' => $this->albumItems->getValues()
        ];
    }

}