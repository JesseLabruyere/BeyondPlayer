<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 7-8-2015
 * Time: 17:20
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Table(name="album_item")
 * @ORM\Entity
 */
class AlbumItem {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // meerdere AlbumItems hebben één user, één user heeft meerdere AlbumItems
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="albums")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    // meerdere AlbumItems hebben per stuk één Album, één Album heeft meerdere AlbumItems
    /**
     * @ORM\ManyToOne(targetEntity="Album")
     * @ORM\JoinColumn(name="albumId", referencedColumnName="id")
     */
    private $album;

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
     * @return \AppBundle\Entity\User;
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \AppBundle\Entity\User $user
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \AppBundle\Entity\Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param \AppBundle\Entity\Album $album
     */
    public function setAlbum(\AppBundle\Entity\Album $album)
    {
        $this->album = $album;
    }

    public function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'album' => $this->album
        ];
    }
}