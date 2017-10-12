<?php declare(strict_types = 1);

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
     * @var int $id
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
     * @return int $id
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string $name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string $slug
     */
    public function getSlug() : string
    {
        return $this->slug;
    }

    /**
     * @return array
     */
    public function getPostTag() : array
    {
        return $this->post_tag->toArray();
    }

    /**
     * @param string $name
     * @return Tag
     */
    public function setName(string $name) : Tag
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
    public function regenerateSlug() : Tag
    {
        $this->slug = (string) S($this->name . ' ' . time())->slugify();

        return $this;
    }

    /**
     * @param PostTag $postTag
     * @return Tag
     */
    public function addPostTag(PostTag $postTag) : Tag
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
    public function removePostTag(PostTag $postTag) : Tag
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
    public function filterArchivedPostsFromTag() : ?Tag
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
