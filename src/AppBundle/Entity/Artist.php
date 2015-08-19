<?php
// src/AppBundle/Entity/Artist.php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ArtistRepository")
 */
class Artist implements JsonSerializable {

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
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="artists")
     * @ORM\JoinTable(name="artist_genre")
     */
    private $genres;


    // één Artist heeft meerdere Artists, dit moet gemapt worden met 2 collections
    /**
     * @ORM\ManyToMany(targetEntity="Artist", mappedBy="subArtists")
     *
     */
    private $parentArtists;

    /**
     * @ORM\ManyToMany(targetEntity="Artist", inversedBy="parentArtists")
     * @ORM\JoinTable(name="artist_artist",
     *      joinColumns={@ORM\JoinColumn(name="artistId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="subArtistId", referencedColumnName="id")}
     *      )
     */
    private $subArtists;

    // één artist heeft meerdere Albums, één Album heeft één artist
    /**
     * @ORM\OneToMany(targetEntity="Album", mappedBy="artist")
     */
    private $albums;

    // één artist heeft meerdere audio, een audio heeft één artist
    /**
     * @ORM\OneToMany(targetEntity="Audio", mappedBy="artist")
     */
    private $audio;

    public function __construct(){
        $this->genres = new ArrayCollection();
        $this->parentArtists = new ArrayCollection();
        $this->subArtists = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->audio =  new ArrayCollection();
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
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @param mixed $genres
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;
    }

    /**
     * // adds a genre and links the artist in that genre
     * @param \AppBundle\Entity\Genre $genre
     */
    public function addGenre($genre)
    {
        $genre->linkArtist($this);
        $this->genres->add($genre);
    }

    /**
     * // just adds a new genre
     * @param \AppBundle\Entity\Genre $genre
     */
    public function linkGenre($genre)
    {
        $this->genres->add($genre);
    }

    /**
     * @return mixed
     */
    public function getSubArtists()
    {
        return $this->subArtists;
    }

    /**
     * @param mixed $subArtists
     */
    public function setSubArtists($subArtists)
    {
        $this->subArtists = $subArtists;
    }

    /**
     * @return mixed
     */
    public function getParentArtists()
    {
        return $this->parentArtists;
    }

    /**
     * @param mixed $parentArtists
     */
    public function setParentArtists($parentArtists)
    {
        $this->parentArtists = $parentArtists;
    }

    /* these the link functions you see below are needed to link many to many
     * these extra two link functions prevent an infinite loop
     */
    /**
     * @param \AppBundle\Entity\Artist $artist
     */
    public function addParentArtist($artist){
        $artist->linkSubArtist($this);
        $this->parentArtists->add($artist);
    }

    /**
     * @param \AppBundle\Entity\Artist $artist
     */
    public function linkSubArtist($artist){
        $this->subArtists->add($artist);
    }

    /**
     * @param \AppBundle\Entity\Artist $artist
     */
    public function addSubArtist($artist){
        $artist->linkParentArtist($this);
        $this->subArtists->add($artist);
    }

    /**
     * @param \AppBundle\Entity\Artist $artist
     */
    public function linkParentArtist($artist){
        $this->parentArtists->add($artist);
    }

    /**
     * @return mixed
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param mixed $albums
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;
    }


    /*
     * @param \AppBundle\Entity\Album $album
     */
    public function addAlbum($album){
        $album->linkArtist($this);
        $this->albums->add($album);
    }

    /*
     * @param \AppBundle\Entity\Album $album
     */
    public function linkAlbum($album){
        $this->albums->add($album);
    }

    /**
     * @return mixed
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * @param mixed $audio
     */
    public function setAudio($audio)
    {
        $this->audio = $audio;
    }


    /**
     * @param \AppBundle\Entity\Audio $audio
     */
    public function addAudio($audio)
    {
        $audio->setArtist($this);
        $this->audio->add($audio);
    }

    /**
     * @param \AppBundle\Entity\Audio $audio
     */
    public function linkAudio($audio)
    {
        $this->audio->add($audio);
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