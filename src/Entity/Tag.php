<?php

namespace MillmanPhotography\Entity;

use Arrayzy\ArrayImitator as A;
use Doctrine\ORM\Mapping as ORM;
use function Stringy\Create as S;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 * @ORM\HasLifecycleCallbacks
 */
class Tag
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
     * @ORM\Column(type="string")
     *
     * @var string $name
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @var string $slug
     */
    protected $slug;

    /**
     * @ORM\OneToMany(targetEntity="PostTag", mappedBy="tag", orphanRemoval=true, cascade={"persist"})
     *
     * @var Collection
     */
    protected $post_tag;

    public function __construct()
    {
        $this->post_tag = new ArrayCollection();
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return Collection
     */
    public function getPostTag()
    {
        return $this->post_tag->toArray();
    }

    /**
     * @param string $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        if (!$this->slug) {
            $this->slug = (string) S($name)->slugify();
        }

        return $this;
    }

    /**
     * @return Tag
     */
    public function regenerateSlug()
    {
        $this->slug = (string) S($this->name . ' ' . time())->slugify();

        return $this;
    }

    /**
     * @param PostTag $postTag
     * @return Tag
     */
    public function addPostTag(PostTag $postTag)
    {
        if (!$this->post_tag->contains($postTag)) {
            $this->post_tag->add($postTag);
        }

        return $this;
    }

    /**
     * @param PostTag $postTag
     * @return Tag
     */
    public function removePostTag(PostTag $postTag)
    {
        if ($this->post_tag->contains($postTag)) {
            $this->post_tag->removeElement($postTag);
        }

        return $this;
    }

    /**
     * Filter archived posts from the Tag
     *
     * @return Tag
     */
    public function filterArchivedPostsFromTag()
    {
        A::create($this->getPostTag())->filter(function (PostTag $postTag) {
            return $postTag->getPost()->getInArchive();
        })->walk(function ($postTag) {
            $this->removePostTag($postTag);
        });

        if (count($this->getPostTag()) !== 0) return $this;

        return null;
    }
}
