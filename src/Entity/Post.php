<?php declare(strict_types = 1);

namespace MillmanPhotography\Entity;

use Arrayzy\ArrayImitator as A;
use Doctrine\ORM\Mapping as ORM;
use function Stringy\Create as S;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use MillmanPhotography\Entity\Traits\Timestamps;
use function Stringy\create;
use Stringy\Stringy;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 * @ORM\HasLifecycleCallbacks
 */
class Post
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
     * @var string $title
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=128)
     *
     * @var string $description
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     *
     * @var string $body
     */
    protected $body;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool $in_archive
     */
    protected $in_archive;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="post")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="PostImage", mappedBy="post", orphanRemoval=true, cascade={"persist"})
     *
     * @var Collection
     */
    protected $post_image;

    /**
     * @ORM\OneToMany(targetEntity="PostTag", mappedBy="post", orphanRemoval=true, cascade={"persist"})
     *
     * @var Collection
     */
    protected $post_tag;

    public function __construct()
    {
        $this->post_image = new ArrayCollection();
        $this->post_tag = new ArrayCollection();
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
     * @return string $body
     */
    public function getBody() :string
    {
        return $this->body;
    }

    /**
     * @return bool $in_archive
     */
    public function getInArchive() :bool
    {
        return $this->in_archive;
    }

    /**
     * @return User
     */
    public function getUser() :User
    {
        return $this->user;
    }

    /**
     * @return array $post_image
     */
    public function getImages() :array
    {
        return $this->post_image->toArray();
    }

    /**
     * @return string $filename
     */
    public function getCoverImage() :string
    {
        foreach ($this->getImages() as $postImage) {
            if (!$postImage->getIsCover()) continue;
            return $postImage->getImage()->getFilename();
        }

        return 'missing';
    }

    /**
     * @return array
     */
    public function getPostTag() :array
    {
        return $this->post_tag->toArray();
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle($title) :Post
    {
        $this->title = $title;

        if (!$this->slug) {
            $this->slug = (string) s($title)->slugify();
        }

        return $this;
    }

    /**
     * @return Post
     */
    public function regenerateSlug() :Post
    {
        $this->slug = (string) S($this->title . ' ' . time())->slugify();

        return $this;
    }

    /**
     * @param string $description
     * @return Post
     */
    public function setDescription(string $description) :Post
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $body
     * @return Post
     */
    public function setBody(string $body) :Post
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param bool $inArchive
     * @return Post
     */
    public function setInArchive(bool $inArchive) :Post
    {
        $this->in_archive = $inArchive;

        return $this;
    }

    /**
     * @param User $user
     * @return Post
     */
    public function setUser(User $user) :Post
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param PostImage $postImage
     * @return Post
     */
    public function addImage(PostImage $postImage) :Post
    {
        if (!$this->post_image->contains($postImage)) {
            $this->post_image->add($postImage);
        }

        return $this;
    }

    /**
     * @param PostImage $postImage
     * @return Post
     */
    public function removeImage(PostImage $postImage) :Post
    {
        if ($this->post_image->contains($postImage)) {
            $this->post_image->removeElement($postImage);
        }

        return $this;
    }

    /**
     * @param PostTag $postTag
     * @return Post
     */
    public function addPostTag(PostTag $postTag) :Post
    {
        if (!$this->post_tag->contains($postTag)) {
            $this->post_tag->add($postTag);
        }

        return $this;
    }

    /**
     * @param PostTag $postTag
     * @return Post
     */
    public function removePostTag(PostTag $postTag) :Post
    {
        if ($this->post_tag->contains($postTag)) {
            $this->post_tag->removeElement($postTag);
        }

        return $this;
    }

    /**
     * Process the tags given for a post
     *
     * @param array $tags
     */
    public function processTags(array $tags) :void
    {
        A::create($tags)->walk(function (Tag $tag) {
            if (!$this->postTagExists($tag)) {
                $postTag = new PostTag();
                $postTag->setPost($this)->setTag($tag);
                $this->addPostTag($postTag);
            }
        });

        $oldTagIds = A::create($this->getPostTag())->map(function (PostTag $postTag) {
            return $postTag->getTag()->getId();
        })->diff(A::create($tags)->map(function (Tag $tag) {
            return $tag->getId();
        })->toArray());

        A::create($this->getPostTag())->walk(function (PostTag $postTag) use ($oldTagIds) {
            $oldTagIds->walk(function ($oldTagId) use ($postTag) {
                if ($postTag->getTag()->getId() == $oldTagId) $this->removePostTag($postTag);
            });
        });
    }

    /**
     * Checks that a tag exists for a post
     *
     * @param Tag $tag
     * @return bool
     */
    private function postTagExists(Tag $tag) :bool
    {
        foreach ($this->getPostTag() as $postTag) {
            if ($postTag->getTag() == $tag) return true;
        }
        return false;
    }

    /**
     * Process the images given for a post
     *
     * @param array $images
     */
    public function processImages(array $images) :void
    {
        A::create($images)->walk(function (Image $image) {
            if (!$this->postImageExists($image)) {
                $postImage = new PostImage();
                $postImage->setPost($this)->setImage($image)->setIsCover(false);
                $this->addImage($postImage);
            }
        });

        $oldImageIds = A::create($this->getImages())->map(function (PostImage $postImage) {
            return $postImage->getImage()->getId();
        })->diff(A::create($images)->map(function (Image $image) {
            return $image->getId();
        })->toArray());

        A::create($this->getImages())->walk(function (PostImage $postImage) use ($oldImageIds) {
            $oldImageIds->walk(function ($oldImageId) use ($postImage) {
                if ($postImage->getImage()->getId() == $oldImageId) $this->removeImage($postImage);
            });
        });
    }

    /**
     * Checks that a image exists for a post
     *
     * @param Image $image
     * @return bool
     */
    private function postImageExists(Image $image) :bool
    {
        foreach ($this->getImages() as $postImage) {
            if ($postImage->getImage()->getId() == $image->getId()) return true;
        }
        return false;
    }
}
