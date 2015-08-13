<?php
// src/AppBundle/Entity/Audio.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Audio implements JsonSerializable
{
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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $originalFileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    // 50mb
    /**
     * @Assert\File(maxSize="50000k")
     */
    private $file;

    // één Audio heeft meerdere Albums, Albums hebben meerdere Audio
    /**
     * @ORM\ManyToMany(targetEntity="Album", mappedBy="audioItems")
     */
    private $albums;

    // variable that is used to temporarily store an old path
    private $temp;


    /* constuctor*/
    public function __construct(){
        $this->albums = new ArrayCollection();
    }

    /**
     * @param string $name
     */
    public function setOriginalFileName($name)
    {
        $this->originalFileName = $name;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'files/audio_files';
    }
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->guessExtension();

            /* we still want to keep the original filename in the database */
            $this->originalFileName = $this->getFile()->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
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
     * Set name
     *
     * @param string $name
     * @return Audio
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get originalFileName
     *
     * @return string 
     */
    public function getOriginalFileName()
    {
        return $this->originalFileName;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Audio
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $albums
     */
    public function setAlbums(\Doctrine\Common\Collections\ArrayCollection $albums)
    {
        $this->albums = $albums;
    }

    /**
     * @param \AppBundle\Entity\Album $album
     */
    public function addAlbum(\AppBundle\Entity\Album $album)
    {
        $album->addAudio($this);
        $this->albums->add($album);
    }

    /**
     * @return mixed
     */
    public function getAlbumData()
    {
        $data = array();

        for($i = 0; $i < count($this->albums); $i++)
        {
            $album = $this->albums->get($i);
            $data[$i] = (object) array('id' => $album->getId(),'name' => $album->getName());
        }

        return $data;
    }

    /* function that gets used when calling json_encode on objects*/
    public function jsonSerialize()
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'originalFilename' => $this->originalFileName,
            'path' => $this->path,
            'file' => $this->file,
            'uploadDirectory' => $this->getUploadDir(),
            'albums' => $this->getAlbumData()
        ];
    }
}
