<?php

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User
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
     * @var string $username
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $password
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $token
     */
    protected $token;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $is_admin
     */
    protected $is_admin = false;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user")
     *
     * @var Collection $posts
     */
    protected $posts;

    /**
     * Initialise posts as an empty ArrayCollection
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string $token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string $is_admin
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @param string $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $token
     * @return void
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param string $isAdmin
     * @return void
     */
    public function setIsAdmin($isAdmin)
    {
        $this->is_admin = $isAdmin;
    }
}
