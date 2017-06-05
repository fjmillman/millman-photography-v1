<?php

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string")
     *
     * @var string $body
     */
    protected $body;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer $image_id
     */
    protected $image_id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="post")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    protected $user;

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
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
     * @return integer $image_id
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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
     * @param string $imageId
     * @return void
     */
    public function setImageId($imageId)
    {
        $this->image_id = $imageId;
    }

    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
