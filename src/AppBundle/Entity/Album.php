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

    // één Album heeft meerdere Audio, Audio hebben meerdere Album
    /**
     * @ORM\ManyToMany(targetEntity="Audio", inversedBy="albums")
     * @ORM\JoinTable(name="album_audio")
     */
    private $audioItems;

    /**
     * @ORM\ManyToOne(targetEntity="Artist", inversedBy="albums")
     * @ORM\JoinColumn(name="artistId", referencedColumnName="id")
     */
    private $artist;

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
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * this method adds the Audio object and also this album in the Audio object
     * @param \AppBundle\Entity\Audio $audio
     */
    public function addAudio(\AppBundle\Entity\Audio $audio){
        /* setting the album on the Audio*/
        $audio->linkAlbum($this);
        /* adding the Audio to the arrayCollection*/
        $this->audioItems->add($audio);
    }

    /*
     *  this method can be used to just add the audio
     *  @param \AppBundle\Entity\Audio $audio
     */
    public function linkAudio(\AppBundle\Entity\Audio $audio){
        $this->audioItems->add($audio);
    }

    /*
     * @param \AppBundle\Entity\Artist $artist
     */
    public function addArtist($artist){
        $artist->linkAlbum($this);
        $this->artist = $artist;
    }

    /*
     * @param \AppBundle\Entity\Artist $artist
     */
    public function linkArtist($artist){
        $this->artist = $artist;
    }

    public function countItems() {
        return count($this->audioItems);
    }



    /* function that gets used when calling json_encode on objects*/
    public function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'count' => count($this->audioItems->getValues()),
            'tracks' => $this->audioItems->getValues()
        ];
    }

}