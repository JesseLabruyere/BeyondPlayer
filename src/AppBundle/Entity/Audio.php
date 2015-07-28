<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Audio
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    // ..... other fields

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     *
     * @var File $audioFile
     */
    protected $audioFile;

    /**
     * @ORM\Column(type="string", length=255, name="audioName")
     *
     * @var string $audioName
     */
    protected $audioName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setAudioFile(File $audioFile = null)
    {
        $this->audioFile = $audioFile;

        if ($audioFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getAudioFile()
    {
        return $this->audioFile;
    }

    /**
     * @param string $imageName
     */
    public function setAudioName($audioName)
    {
        $this->audioName = $audioName;
    }

    /**
     * @return string
     */
    public function getAudioName()
    {
        return $this->audioName;
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
