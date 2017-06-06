<?php

namespace MillmanPhotography\Entity;

use function Stringy\Create as S;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use MillmanPhotography\Entity\Traits\Timestamps;

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
     * @var integer $id
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="post")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="PostImage", mappedBy="post")
     *
     * @var Collection
     */
    protected $post_image;

    public function __construct()
    {
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
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string $body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return array $post_image
     */
    public function getImages()
    {
        return $this->post_image->toArray();
    }

    /**
     * @return string $filename
     */
    public function getCoverImage()
    {
        foreach ($this->getImages() as $postImage) {
            if (!$postImage->getIsCover()) continue;
            return $postImage->getImage()->getFilename();
        }
        return 'missing';
    }

    /**
     * @return void
     */
    public function regenerateSlug()
    {
        $this->slug = (string) S($this->title . ' ' . time())->slugify();
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param string $body
     * @return void
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param PostImage $postImage
     * @return void
     */
    public function addImage(PostImage $postImage)
    {
        if (!$this->post_image->contains($postImage)) {
            $this->post_image->add($postImage);
        }
    }

    /**
     * @param PostImage $postImage
     * @return void
     */
    public function removeImage(PostImage $postImage)
    {
        if ($this->post_image->contains($postImage)) {
            $this->post_image->removeElement($postImage);
        }
    }
}
