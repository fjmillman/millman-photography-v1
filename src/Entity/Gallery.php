<?php declare(strict_types = 1);

namespace MillmanPhotography\Entity;

use Arrayzy\ArrayImitator as A;
use Doctrine\ORM\Mapping as ORM;
use Dotenv\Dotenv;
use Projek\Slim\Monolog;
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
     * @var int $id
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
     * @var bool $is_front
     */
    protected $is_front;

    /**
     * @ORM\OneToMany(targetEntity="GalleryImage", mappedBy="gallery", orphanRemoval=true, cascade={"persist"})
     *
     * @var Collection
     */
    protected $gallery_image;

    public function __construct()
    {
        $this->gallery_image = new ArrayCollection();
    }

    /**
     * @return int $id
     */
    public function getId() :int
    {
        return $this->id;
    }

    /**
     * @return string $slug
     */
    public function getSlug() :string
    {
        return $this->slug;
    }

    /**
     * @return string $title
     */
    public function getTitle() :string
    {
        return $this->title;
    }

    /**
     * @return string $description
     */
    public function getDescription() :string
    {
        return $this->description;
    }

    /**
     * @return bool $is_front
     */
    public function getIsFront() :bool
    {
        return $this->is_front;
    }

    /**
     * @return array $gallery_image
     */
    public function getImages() :array
    {
        return $this->gallery_image->toArray();
    }

    /**
     * @return string $filename
     */
    public function getCoverImage() :string
    {
        foreach ($this->getImages() as $galleryImage) {
            if (!$galleryImage->getIsCover()) continue;
            return $galleryImage->getImage()->getFilename();
        }

        return 'missing';
    }

    /**
     * @return array
     */
    public function getImageData() :array
    {
        return A::create($this->getImages())->map(function (GalleryImage $galleryImage) {
            list($width, $height) = getimagesize('img/' . $galleryImage->getImage()->getFilename() . '.jpg');
            return [
                'src' => '/img/' . $galleryImage->getImage()->getFilename() . '.jpg',
                'height' => $height,
                'width' => $width,
            ];
        })->toArray();
    }

    /**
     * @return Gallery
     */
    public function regenerateSlug() :Gallery
    {
        $this->slug = (string) S($this->title . ' ' . time())->slugify();

        return $this;
    }

    /**
     * @param string $title
     * @return Gallery
     */
    public function setTitle(string $title) :Gallery
    {
        $this->title = $title;

        if (!$this->slug) {
            $this->slug = (string) S($this->title)->slugify();
        }

        return $this;
    }

    /**
     * @param string $description
     * @return Gallery
     */
    public function setDescription(string $description) :Gallery
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param boolean $isFront
     * @return Gallery
     */
    public function setIsFront(bool $isFront) :Gallery
    {
        $this->is_front = $isFront;

        return $this;
    }

    /**
     * @param GalleryImage $galleryImage
     * @return Gallery
     */
    public function addImage(GalleryImage $galleryImage) :Gallery
    {
        if (!$this->gallery_image->contains($galleryImage)) {
            $this->gallery_image->add($galleryImage);
        }

        return $this;
    }

    /**
     * @param GalleryImage $galleryImage
     * @return Gallery
     */
    public function removeImage(GalleryImage $galleryImage) :Gallery
    {
        if ($this->gallery_image->contains($galleryImage)) {
            $this->gallery_image->removeElement($galleryImage);
        }

        return $this;
    }

    /**
     * Process the images given for a gallery
     *
     * @param array $images
     */
    public function processImages(array $images) :void
    {
        A::create($images)->walk(function (Image $image) {
            if (!$this->galleryImageExists($image)) {
                $galleryImage = new GalleryImage();
                $galleryImage->setGallery($this)->setImage($image)->setIsCover(false);
                $this->addImage($galleryImage);
            }
        });

        $oldImageIds = A::create($this->getImages())->map(function (GalleryImage $galleryImage) {
            return $galleryImage->getImage()->getId();
        })->diff(A::create($images)->map(function (Image $image) {
            return $image->getId();
        })->toArray());

        A::create($this->getImages())->walk(function (GalleryImage $galleryImage) use ($oldImageIds) {
            $oldImageIds->walk(function ($oldImageId) use ($galleryImage) {
                if ($galleryImage->getImage()->getId() == $oldImageId) $this->removeImage($galleryImage);
            });
        });
    }

    /**
     * Checks that a image exists for a post
     *
     * @param Image $image
     * @return bool
     */
    private function galleryImageExists(Image $image) :bool
    {
        foreach ($this->getImages() as $galleryImage) {
            if ($galleryImage->getImage()->getId() == $image->getId()) return true;
        }
        return false;
    }
}
