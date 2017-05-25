<?php

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string $name
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string $email
     */
    protected $description;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer $image_id
     */
    protected $image_id;

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
     * @return integer $image_id
     */
    public function getImageId()
    {
        return $this->image_id;
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
     * @param integer $imageId
     * @return void
     */
    public function setImageId($imageId)
    {
        $this->image_id = $imageId;
    }
}
