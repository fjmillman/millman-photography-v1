<?php

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;
use function Stringy\Create as S;
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
     * @ORM\Column(type="string", unique=true)
     *
     * @var string $slug
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string $name
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=128)
     *
     * @var string $email
     */
    protected $description;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $is_front
     */
    protected $is_front;

    /**
     * @ORM\OneToMany(targetEntity="GalleryImage", mappedBy="gallery")
     *
     * @var Collection
     */
    protected $gallery_image;

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
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
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
     * @return boolean $is_front
     */
    public function getIsFront()
    {
        return $this->is_front;
    }

    /**
     * @return array $gallery_image
     */
    public function getImages()
    {
        return $this->gallery_image->toArray();
    }

    /**
     * @return string $filename
     */
    public function getCoverImage()
    {
        foreach ($this->getImages() as $postImage) {
            if (!$postImage->getIsCover()) continue;
            return $postImage->getImage()->getFilename();
        }
        return 'missing';
    }

    /**
     * @return void
     */
    public function regenerateSlug()
    {
        $this->slug = (string) S($this->title . ' ' . time())->slugify();
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;

        if (!$this->slug) {
            $this->slug = (string) S($this->title)->slugify();
        }
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
     * @param boolean $isFront
     * @return void
     */
    public function setIsFront($isFront)
    {
        $this->is_front = $isFront;
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
