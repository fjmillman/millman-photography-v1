<?php declare(strict_types = 1);

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="showcase_image")
 * @ORM\HasLifecycleCallbacks
 */
class ShowcaseImage
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
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     *
     * @var Image $image
     */
    protected $image;

    /**
     * @return int $id
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return Image $image
     */
    public function getImage() : Image
    {
        return $this->image;
    }

    /**
     * @param Image $image
     * @return ShowcaseImage
     */
    public function setImage(Image $image) : ShowcaseImage
    {
        $this->image = $image;

        return $this;
    }
}
