<?php

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="gallery_image")
 * @ORM\HasLifecycleCallbacks
 */
class GalleryImage
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
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="gallery_image")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id", nullable=false)
     *
     * @var Gallery $gallery
     */
    protected $gallery;

    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="gallery_image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     *
     * @var Image $image
     */
    protected $image;

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Gallery $gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @return Image $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Gallery $gallery
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}
