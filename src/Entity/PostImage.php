<?php

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
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="post_image")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     *
     * @var Post $post
     */
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="post_image")
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
     * @return Post $post
     */
    public function getPost()
    {
        return $this->post;
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
     * @param Post $post
     * @return void
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @param Image $image
     * @return void
     */
    public function setImage($image)
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
