<?php

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="gallery")
 * @ORM\HasLifecycleCallbacks
 */
class Gallery
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string $name
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string $email
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="GalleryImage", mappedBy="gallery")
     *
     * @var Collection
     */
    protected $gallery_image;

    /**
     * Initialise gallery_image as an empty ArrayCollection
     */
    public function __construct()
    {
        $this->gallery_image = new ArrayCollection();
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array $gallery_image
     */
    public function getImages()
    {
        return $this->gallery_image->toArray();
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param GalleryImage $galleryImage
     * @return void
     */
    public function addImage(GalleryImage $galleryImage)
    {
        if (!$this->gallery_image->contains($galleryImage)) {
            $this->gallery_image->add($galleryImage);
        }
    }

    /**
     * @param GalleryImage $galleryImage
     * @return void
     */
    public function removeImage(GalleryImage $galleryImage)
    {
        if ($this->gallery_image->contains($galleryImage)) {
            $this->gallery_image->removeElement($galleryImage);
        }
    }
}
