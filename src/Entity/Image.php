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
     * @ORM\OneToMany(targetEntity="PostImage", mappedBy="image")
     *
     * @var Collection
     */
    protected $post_image;

    public function __construct()
    {
        $this->gallery_image = new ArrayCollection();
        $this->post_image = new ArrayCollection();
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
     * @return array $post_image
     */
    public function getPosts()
    {
        return $this->post_image->toArray();
    }

    /**
     * @param string $filename
     * @return Image
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @param string $caption
     * @return Image
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @param GalleryImage $galleryImage
     * @return Image
     */
    public function addGallery(GalleryImage $galleryImage)
    {
        if (!$this->gallery_image->contains($galleryImage)) {
            $this->gallery_image->add($galleryImage);
        }

        return $this;
    }

    /**
     * @param GalleryImage $galleryImage
     * @return Image
     */
    public function removeGallery(GalleryImage $galleryImage)
    {
        if ($this->gallery_image->contains($galleryImage)) {
            $this->gallery_image->removeElement($galleryImage);
        }

        return $this;
    }

    /**
     * @param PostImage $postImage
     * @return Image
     */
    public function addPost(PostImage $postImage)
    {
        if (!$this->post_image->contains($postImage)) {
            $this->post_image->add($postImage);
        }

        return $this;
    }

    /**
     * @param PostImage $postImage
     * @return Image
     */
    public function removePost(PostImage $postImage)
    {
        if ($this->post_image->contains($postImage)) {
            $this->post_image->removeElement($postImage);
        }

        return $this;
    }
}
