<?php

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @var string $filename
     */
    protected $filename;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string $caption
     */
    protected $caption;

    /**
     * @ORM\OneToMany(targetEntity="GalleryImage", mappedBy="image")
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
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return string $caption
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return array $gallery_image
     */
    public function getGalleries()
    {
        return $this->gallery_image->toArray();
    }

    /**
     * @param string $filename
     * @return void
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param string $caption
     * @return void
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @param GalleryImage $galleryImage
     * @return void
     */
    public function addGallery(GalleryImage $galleryImage)
    {
        if (!$this->gallery_image->contains($galleryImage)) {
            $this->gallery_image->add($galleryImage);
        }
    }

    /**
     * @param GalleryImage $galleryImage
     * @return void
     */
    public function removeGallery(GalleryImage $galleryImage)
    {
        if ($this->gallery_image->contains($galleryImage)) {
            $this->gallery_image->removeElement($galleryImage);
        }
    }
}
