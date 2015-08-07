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


    // één playList heeft meerdere listItems, listItems hebben één playList
    /**
     * @ORM\OneToMany(targetEntity="ListItem", mappedBy="playlist")
     */
    private $listItems;



    public function __construct() {
        $this->listItems = new ArrayCollection();
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
     * @param \AppBundle\Entity\ListItem $listItem
     * @return Playlist
     */
    public function addListItem(\AppBundle\Entity\ListItem $listItem)
    {
        // we add the playlist to the listItem and not the other way around
        $listItem->setPlaylist($this);
        // we add the listItem to the arrayCollection, we use the id as key value
        $this->listItems->add($listItem);

        return $this;
    }

    /**
     * Remove listItems
     *
     * @param \AppBundle\Entity\ListItem $listItems
     */
    public function removeListItem(\AppBundle\Entity\ListItem $listItems)
    {
        $this->listItems->removeElement($listItems);
    }

    /**
     * Get listItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListItems()
    {
        return $this->listItems;
    }

    /**
     * get listItem bij Id
     *
     * @param int $id
     * @return \AppBundle\Entity\ListItem
     */
    public function getListItemById($id)
    {
        for($i = 0; $i < count($this->listItems); $i++)
        {
            if($this->listItems->get($i)->getId() == $id) {
                return $this->listItems->get($i);
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
        return $this->listItems->first();
    }

    /* function that gets used when calling json_encode on objects*/
    public function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'listName' => $this->listName,
            'listItems' => $this->listItems->getValues()
        ];
    }
}
