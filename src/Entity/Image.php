<?php declare(strict_types = 1);

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;
use function Stringy\Create as S;
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
     * @var int $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string $title
     */
    protected $title;

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
     * @ORM\OneToOne(targetEntity="ShowcaseImage", mappedBy="image", orphanRemoval=true, cascade={"persist"})
     *
     * @var ShowcaseImage
     */
    protected $showcase_image;

    /**
     * @ORM\OneToMany(targetEntity="GalleryImage", mappedBy="image", orphanRemoval=true, cascade={"persist"})
     *
     * @var Collection
     */
    protected $gallery_image;

    /**
     * @ORM\OneToMany(targetEntity="PostImage", mappedBy="image", orphanRemoval=true, cascade={"persist"})
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
     * @return int $id
     */
    public function getId() :int
    {
        return $this->id;
    }

    /**
     * @return string $title
     */
    public function getTitle() :string
    {
        return $this->title;
    }

    /**
     * @return string $filename
     */
    public function getFilename() :string
    {
        return $this->filename;
    }

    /**
     * @return string $caption
     */
    public function getCaption() :string
    {
        return $this->caption;
    }

    /**
     * @return ShowcaseImage $showcase_image
     */
    public function getShowcaseImage() : ? ShowcaseImage
    {
        return $this->showcase_image;
    }

    /**
     * @return array $gallery_image
     */
    public function getGalleries() :array
    {
        return $this->gallery_image->toArray();
    }

    /**
     * @return array $post_image
     */
    public function getPosts() :array
    {
        return $this->post_image->toArray();
    }

    /**
     * @param string $title
     * @return Image
     */
    public function setTitle($title) :Image
    {
        $this->title = $title;

        if (!$this->filename) {
            $this->filename = (string) S($title)->slugify();
        }

        return $this;
    }

    /**
     * @return Image
     */
    public function regenerateFilename() :Image
    {
        $this->filename = (string) S($this->filename . ' ' . time())->slugify();

        return $this;
    }

    /**
     * @param string $caption
     * @return Image
     */
    public function setCaption(string $caption) :Image
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @param GalleryImage $galleryImage
     * @return Image
     */
    public function addGallery(GalleryImage $galleryImage) :Image
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
    public function removeGallery(GalleryImage $galleryImage) :Image
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
    public function addPost(PostImage $postImage) :Image
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
    public function removePost(PostImage $postImage) :Image
    {
        if ($this->post_image->contains($postImage)) {
            $this->post_image->removeElement($postImage);
        }

        return $this;
    }
}
