<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;


/**
 * @ORM\Table(name="list_item")
 * @ORM\Entity
 */
class ListItem implements JsonSerializable{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // meerdere listItems hebben per stuk één playList, één playList heeft meerdere listItems
    /**
     * @ORM\ManyToOne(targetEntity="Playlist", inversedBy="listItems")
     * @ORM\JoinColumn(name="playlistId", referencedColumnName="id")
     */
    private $playlist;

    // meerdere listItems hebben per stuk één Audio, één Audio heeft meerdere listItems
    /**
     * @ORM\ManyToOne(targetEntity="Audio")
     * @ORM\JoinColumn(name="audioId", referencedColumnName="id")
     */
    private $audio;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set playlist
     *
     * @param \AppBundle\Entity\Playlist $playlist
     * @return ListItem
     */
    public function setPlaylist(\AppBundle\Entity\Playlist $playlist = null)
    {
        $this->playlist = $playlist;
    
        return $this;
    }

    /**
     * Get playlist
     *
     * @return \AppBundle\Entity\Playlist 
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }

    /**
     * Set audio
     *
     * @param \AppBundle\Entity\Audio $audio
     * @return ListItem
     */
    public function setAudio(\AppBundle\Entity\Audio $audio = null)
    {
        $this->audio = $audio;
    
        return $this;
    }

    /**
     * Get audio
     *
     * @return \AppBundle\Entity\Audio 
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /* function that gets used when calling json_encode on objects*/
    public function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'audio' => $this->audio
        ];
    }
}
