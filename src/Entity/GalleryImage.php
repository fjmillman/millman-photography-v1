<?php declare(strict_types = 1);

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
     * @var int $id
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="gallery_image", cascade={"persist"})
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id", nullable=false)
     *
     * @var Gallery $gallery
     */
    protected $gallery;

    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="gallery_image", cascade={"persist"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     *
     * @var Image $image
     */
    protected $image;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool $is_cover
     */
    protected $is_cover;

    /**
     * @return int $id
     */
    public function getId() :int
    {
        return $this->id;
    }

    /**
     * @return Gallery $gallery
     */
    public function getGallery() :Gallery
    {
        return $this->gallery;
    }

    /**
     * @return Image $image
     */
    public function getImage() :Image
    {
        return $this->image;
    }

    /**
     * @return bool $is_cover
     */
    public function getIsCover() :bool
    {
        return $this->is_cover;
    }

    /**
     * @param Gallery $gallery
     * @return GalleryImage
     */
    public function setGallery(Gallery $gallery) :GalleryImage
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @param Image $image
     * @return GalleryImage
     */
    public function setImage(Image $image) :GalleryImage
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @param bool $isCover
     * @return GalleryImage
     */
    public function setIsCover(bool $isCover) :GalleryImage
    {
        $this->is_cover = $isCover;

        return $this;
    }
}
