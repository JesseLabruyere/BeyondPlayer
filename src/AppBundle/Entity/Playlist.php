<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="playlist")
 * @ORM\Entity
 */
class Playlist {

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
}
