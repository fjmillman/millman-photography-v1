<?php

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="post_tag")
 * @ORM\HasLifecycleCallbacks
 */
class PostTag
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
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="post_tag", cascade={"persist"})
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     *
     * @var Post $post
     */
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="post_tag", cascade={"persist"})
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false)
     *
     * @var Tag $tag
     */
    protected $tag;

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
     * @return Tag $tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param Post $post
     * @return PostTag
     */
    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @param Tag $tag
     * @return PostTag
     */
    public function setTag(Tag $tag)
    {
        $this->tag = $tag;

        return $this;
    }
}
