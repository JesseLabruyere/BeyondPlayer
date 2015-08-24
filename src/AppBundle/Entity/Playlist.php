<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Table(name="playlist")
 * @ORM\Entity
 */
class Playlist implements JsonSerializable{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="playLists")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     */
    private $listName;

    // playLists hebben meerdere Audio, Audio hebben meerdere playLists
    /**
     *
     * @ORM\ManyToMany(targetEntity="Audio")
     * @ORM\JoinTable(name="playlist_audio")
     */
    private $audioItems;



    public function __construct() {
        $this->audioItems = new ArrayCollection();
    }

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
     * Set listName
     *
     * @param integer $listName
     * @return Playlist
     */
    public function setListName($listName)
    {
        $this->listName = $listName;

        return $this;
    }

    /**
     * Get listName
     *
     * @return integer
     */
    public function getListName()
    {
        return $this->listName;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Playlist
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add listItems
     *
     * @param \AppBundle\Entity\Audio $audio
     * @return Playlist
     */
    public function addAudio(\AppBundle\Entity\Audio $audio)
    {
        // we add the listItem to the arrayCollection, we use the id as key value
        $this->audioItems->add($audio);

        return $this;
    }

    /**
     * Remove listItems
     *
     * @param \AppBundle\Entity\Audio $audio
     */
    public function remove(\AppBundle\Entity\Audio $audio)
    {
        $this->audioItems->removeElement($audio);
    }

    /**
     * Get listItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListItems()
    {
        return $this->audioItems;
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
     * get Audio bij Id
     *
     * @param int $id
     * @return \AppBundle\Entity\Audio
     */
    public function getListItemById($id)
    {
        for($i = 0; $i < count($this->audioItems); $i++)
        {
            if($this->audioItems->get($i)->getId() == $id) {
                return $this->audioItems->get($i);
            }
        }
    }

    /*
     * get the first Listitem
     *
     * @return \AppBundle\Entity\ListItem
     */
    public function getFirstItem()
    {
        //return $this->listItems->get()
        return $this->audioItems->first();
    }

    /* function that gets used when calling json_encode on objects*/
    public function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'listName' => $this->listName,
            'count' => count($this->audioItems->getValues()),
            'listItems' => $this->audioItems->getValues()
        ];
    }
}
