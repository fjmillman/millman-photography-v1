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
     * @ORM\Column(type="boolean")
     *
     * @var boolean $is_cover
     */
    protected $is_cover;

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
     * @return boolean $is_cover
     */
    public function getIsCover()
    {
        return $this->is_cover;
    }

    /**
     * @param Gallery $gallery
     * @return void
     */
    public function setGallery(Gallery $gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * @param Image $image
     * @return void
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @param $isCover
     * @return void
     */
    public function setIsCover($isCover)
    {
        $this->is_cover = $isCover;
    }
}
