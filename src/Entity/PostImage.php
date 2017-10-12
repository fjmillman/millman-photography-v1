<?php declare(strict_types = 1);

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="post_image")
 * @ORM\HasLifecycleCallbacks
 */
class PostImage
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
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="post_image", cascade={"persist"})
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     *
     * @var Post $post
     */
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="post_image", cascade={"persist"})
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
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return Post $post
     */
    public function getPost() : Post
    {
        return $this->post;
    }

    /**
     * @return Image $image
     */
    public function getImage() : Image
    {
        return $this->image;
    }

    /**
     * @return bool $is_cover
     */
    public function getIsCover() : bool
    {
        return $this->is_cover;
    }

    /**
     * @param Post $post
     * @return PostImage
     */
    public function setPost(Post $post) : PostImage
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @param Image $image
     * @return PostImage
     */
    public function setImage(Image $image) : PostImage
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @param bool $isCover
     * @return PostImage
     */
    public function setIsCover(bool $isCover) : PostImage
    {
        $this->is_cover = $isCover;

        return $this;
    }
}
