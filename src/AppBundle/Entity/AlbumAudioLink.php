<?php
// src/AppBundle/Entity/AlbumAudioLink.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Table(name="album_audio_link")
 * @ORM\Entity
 */
class AlbumAudioLink implements JsonSerializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // meerdere AlbumAudioLinks hebben per stuk één Album, één Album heeft meerdere AlbumAudioLinks
    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="albumItems")
     * @ORM\JoinColumn(name="albumId", referencedColumnName="id")
     */
    private $album;

    // meerdere AlbumAudioLinks hebben per stuk één Audio, één Audio heeft meerdere AlbumAudioLinks
    /**
     * @ORM\ManyToOne(targetEntity="Audio", inversedBy="albums")
     * @ORM\JoinColumn(name="audioId", referencedColumnName="id")
     */
    private $audio;


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
     * @return mixed
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param mixed $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }



    public function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'album' => $this->album,
            'audio' => $this->audio
        ];
    }
}