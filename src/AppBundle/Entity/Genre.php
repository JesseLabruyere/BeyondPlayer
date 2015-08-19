<?php
// src/AppBundle/Entity/Genre.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Entity
 */
class Genre implements JsonSerializable {

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

    // één Artist heeft meerdere Genres, één Genre heeft meerdere Artists
    /**
     * @ORM\ManyToMany(targetEntity="Artist", mappedBy="genres")
     */
    private $artists;

    // één Genre heeft meerdere Genres, dit moet gemapt worden met 2 collections
    /**
     * @ORM\ManyToMany(targetEntity="Genre", mappedBy="subGenres")
     *
     */
    private $parentGenres;

    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="parentGenres")
     * @ORM\JoinTable(name="genre_genre",
     *      joinColumns={@ORM\JoinColumn(name="genreId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="subGenreId", referencedColumnName="id")}
     *      )
     */
    private $subGenres;


    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->parentGenres = new ArrayCollection();
        $this->subGenres = new ArrayCollection();
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
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * @param mixed $artists
     */
    public function setArtists($artists)
    {
        $this->artists = $artists;
    }

    /**
     * @return mixed
     */
    public function getParentGenres()
    {
        return $this->parentGenres;
    }

    /**
     * @param mixed $parentGenres
     */
    public function setParentGenres($parentGenres)
    {
        $this->parentGenres = $parentGenres;
    }

    /**
     * @return mixed
     */
    public function getSubGenres()
    {
        return $this->subGenres;
    }

    /**
     * @param mixed $subGenres
     */
    public function setSubGenres($subGenres)
    {
        $this->subGenres = $subGenres;
    }

    /* these the link functions you see below are needed to link many to many
     * these extra two link functions prevent an infinite loop
     */
    /**
     * @param \AppBundle\Entity\Genre $genre
     */
    public function addSubGenre($genre){
        $genre->linkSubGenre($this);
        $this->subGenres->add($genre);
    }

    /**
     * @param \AppBundle\Entity\Genre $genre
     */
    public function linkParentGenre($genre){
        $this->parentGenres->add($genre);
    }

    /**
     * @param \AppBundle\Entity\Genre $genre
     */
    public function addParentGenre($genre){
        $genre->linkSubGenre($this);
        $this->parentGenres->add($genre);
    }

    /**
     * @param \AppBundle\Entity\Genre $genre
     */
    public function linkSubGenre($genre){
        $this->subGenres->add($genre);
    }

    /**
     * adds an artist and links this genre to that artist
     * @param \AppBundle\Entity\Artist $artist
     */
    public function addArtist($artist){
        $artist->linkGenre($this);
        $this->artists->add($artist);
    }

    /**
     * just adds an artist
     * @param \AppBundle\Entity\Artist $artist
     */
    public function linkArtist($artist){
        $this->artists->add($artist);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'name' => $this->name
        ];
    }


}